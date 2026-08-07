<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class WhatsappWebhookController extends Controller
{
    // Ganti dengan string bebas milikmu sendiri, harus SAMA PERSIS
    // dengan yang kamu isi di kolom "Verify Token" pada dashboard Meta.
    private string $verifyToken = 'rekapsampurasun2026';

    /**
     * Dipanggil Meta SEKALI saja saat kamu klik "Verify and Save"
     * di dashboard webhook. Wajib membalas persis nilai hub_challenge.
     */
    public function verify(Request $request)
    {
        $mode = $request->query('hub_mode');
        $token = $request->query('hub_verify_token');
        $challenge = $request->query('hub_challenge');

        if ($mode === 'subscribe' && $token === $this->verifyToken) {
            return response($challenge, 200);
        }

        return response('Forbidden', 403);
    }

    /**
     * Dipanggil Meta SETIAP KALI ada pesan/event baru masuk.
     */
    public function handle(Request $request)
    {
        $payload = $request->all();

        // Selalu log dulu payload mentahnya selama tahap belajar/testing,
        // supaya kamu bisa lihat persis bentuk data yang dikirim Meta.
        Log::info('WA webhook payload', $payload);

        // Struktur payload Meta itu bertingkat (nested), ini cara amannya
        // ambil bagian pesan tanpa bikin error kalau strukturnya beda
        // (misal payload status pesan terkirim/dibaca, bukan pesan masuk).
        $entry = $payload['entry'][0] ?? null;
        $change = $entry['changes'][0] ?? null;
        $value = $change['value'] ?? null;
        $message = $value['messages'][0] ?? null;

        if (!$message) {
            // Bukan pesan masuk (mungkin cuma notifikasi status), abaikan saja.
            return response()->json(['status' => 'ignored']);
        }

        $from = $message['from'] ?? null;           // nomor HP pengirim
        $text = $message['text']['body'] ?? null;    // isi pesan

        if (!$text) {
            return response()->json(['status' => 'ignored']);
        }

        // ==== BAGIAN PARSING TEMPLATE ====
        // Asumsi warga membalas dengan format:
        // Nama: Budi Santoso
        // NIK: 3201xxxxxxxx
        // Jenis Kelamin: Laki-laki
        // Kecamatan: ...
        // Kelurahan: ...
        // Layanan: KTP
        // Keluhan: KTP saya hilang

        $data = $this->parseTemplate($text);

        if (!$data) {
            // Format tidak cocok / belum lengkap, jangan disimpan dulu.
            // (Di sini nanti kamu bisa tambahkan logic auto-reply
            // "Mohon isi ulang sesuai format" via Cloud API.)
            return response()->json(['status' => 'format_tidak_sesuai']);
        }

        // Cari kategori berdasarkan nama layanan yang diketik warga
        $category = Category::where('name', 'like', $data['layanan'])->first();

        Question::create([
            'tanggal' => now()->toDateString(),
            'nik' => $data['nik'],
            'nama' => $data['nama'],
            'no_hp' => $from,
            'jenis_kelamin' => $this->normalizeGender($data['jenis_kelamin']),
            'kecamatan' => $data['kecamatan'] ?? null,
            'kelurahan' => $data['kelurahan'] ?? null,
            'jenis_layanan_id' => $category?->id,
            'detail' => $data['keluhan'] ?? null,
            'jam_masuk' => now()->format('H:i'),
            'jam_di_balasan' => null, // diisi operator nanti pas kasih solusi
        ]);

        return response()->json(['status' => 'saved']);
    }

    /**
     * Parsing sederhana berbasis label "Key: Value" per baris.
     * Return null kalau field wajib belum lengkap.
     */
    private function parseTemplate(string $text): ?array
    {
        $lines = explode("\n", $text);
        $result = [];

        foreach ($lines as $line) {
            if (str_contains($line, ':')) {
                [$key, $value] = explode(':', $line, 2);
                $key = strtolower(trim($key));
                $value = trim($value);
                $result[$key] = $value;
            }
        }

        // Mapping nama field template -> nama field yang dipakai internal
        $mapped = [
            'nama' => $result['nama'] ?? null,
            'nik' => $result['nik'] ?? null,
            'jenis_kelamin' => $result['jenis kelamin'] ?? null,
            'kecamatan' => $result['kecamatan'] ?? null,
            'kelurahan' => $result['kelurahan'] ?? null,
            'layanan' => $result['layanan'] ?? null,
            'keluhan' => $result['keluhan'] ?? null,
        ];

        // Field wajib sesuai validasi di QuestionController::store()
        if (!$mapped['nama'] || !$mapped['nik'] || !$mapped['jenis_kelamin']) {
            return null;
        }

        return $mapped;
    }

    /**
     * Normalisasi jawaban jenis kelamin dari warga (L/l/laki/dst)
     * ke format persis yang divalidasi QuestionController: 'Laki-laki' / 'Perempuan'.
     */
    private function normalizeGender(string $raw): string
    {
        $raw = strtolower(trim($raw));

        if (in_array($raw, ['l', 'laki', 'laki-laki', 'pria'])) {
            return 'Laki-laki';
        }

        if (in_array($raw, ['p', 'perempuan', 'wanita'])) {
            return 'Perempuan';
        }

        // Default aman kalau tidak dikenali, supaya tidak lolos validasi diam-diam.
        // Nanti bisa ditingkatkan: reject & minta warga isi ulang.
        return $raw;
    }
}
