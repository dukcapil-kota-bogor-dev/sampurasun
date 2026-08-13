<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Category;

class QuestionController extends Controller
{
    /**
     * Display a listing of the questions.
     */
    public function index(Request $request)
    {
        $categoryId = $request->query('jenis_layanan');
        $q = $request->query('q');
        $date = $request->query('date');
        $month = $request->query('month');
        $year = $request->query('year');
        $day = $request->query('day');

        // Build base query; we'll order by absolute time-difference (selisih) ascending,
        // then by tanggal (Y-m-d) and jam_masuk so rows show smallest selisih on top,
        // and dates/times ordered from earliest to latest top->bottom.
        $query = Question::query();

        if (!empty($categoryId)) {
            $query->where('jenis_layanan_id', $categoryId);
        }

        if (!empty($q)) {
            $query->where(function($sub) use ($q) {
                $sub->where('nama', 'like', "%{$q}%")
                    ->orWhere('nik', 'like', "%{$q}%")
                    ->orWhere('no_hp', 'like', "%{$q}%")
                    ->orWhere('jenis_kelamin', 'like', "%{$q}%")
                    ->orWhere('kecamatan', 'like', "%{$q}%")
                    ->orWhere('kelurahan', 'like', "%{$q}%")
                    ->orWhereHas('jenisLayanan', function($qq) use ($q) {
                        $qq->where('name', 'like', "%{$q}%");
                    });
            });
        }

        if (!empty($date)) {
            $query->whereDate('tanggal', $date);
        }

        if (!empty($month)) {
            $query->whereMonth('tanggal', $month);
        }

        if (!empty($year)) {
            $query->whereYear('tanggal', $year);
        }

        if (!empty($day)) {
            $map = [
                'senin' => 0,
                'selasa' => 1,
                'rabu' => 2,
                'kamis' => 3,
                'jumat' => 4,
                'sabtu' => 5,
                'minggu' => 6,
            ];
            $key = strtolower($day);
            if (isset($map[$key])) {
                // WEEKDAY returns 0 (Monday) - 6 (Sunday)
                $query->whereRaw('WEEKDAY(tanggal) = ?', [$map[$key]]);
            }
        }

        // Order: tanggal ascending (terlama paling atas), lalu jam_masuk ascending
        // Agar jam kosong (NULL) berada di bawah, prioritaskan non-null dulu.
        $query->orderBy('tanggal', 'asc')
            ->orderByRaw("CASE WHEN jam_masuk IS NULL THEN 1 ELSE 0 END ASC")
            ->orderBy('jam_masuk', 'asc');

        $questions = $query->paginate(15)->appends($request->only('q', 'date', 'month', 'year', 'day'));

        return view('questions.index', compact('questions', 'q'));
    }

    /**
     * Show the form for creating a new question.
     */
    public function create()
    {
        // Ensure static service categories exist in the DB so they appear in the select
        $serviceCategories = [
            'KK','KTP','KIA','Akta Kelahiran','Akta Kematian','Akta Perkawinan','Akta Perceraian',
            'SKTT','IKD','Surat Pindah','Kedatangan','Layanan Online','Pengaduan','BAPR',
            'Update Data','Ganti Foto','Kutipan Kedua','Ludo', 'Lainnya'
        ];

        foreach ($serviceCategories as $sc) {
            Category::firstOrCreate(['name' => $sc]);
        }

        $categories = Category::all();

        return view('questions.create', compact('categories'));
    }

    /**
     * Store a newly created question in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'tanggal' => 'required|date',
            'nik' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'kecamatan' => 'nullable|string|max:255',
            'kelurahan' => 'nullable|string|max:255',
            'jenis_layanan' => 'nullable|exists:categories,id',
            'detail' => 'nullable|string',
            'jam_masuk' => 'nullable',
            'jam_di_balasan' => 'nullable',
        ]);

        // Normalize time formats: accept H:i or H:i:s and store as H:i
        foreach (['jam_masuk', 'jam_di_balasan'] as $tf) {
            if (!empty($request->input($tf))) {
                $val = $request->input($tf);
                try {
                    try {
                        $t = \Carbon\Carbon::createFromFormat('H:i', $val);
                    } catch (\Exception $e) {
                        $t = \Carbon\Carbon::createFromFormat('H:i:s', $val);
                    }
                    $data[$tf] = $t->format('H:i');
                } catch (\Exception $e) {
                    return redirect()->back()->withErrors([$tf => 'Format waktu tidak valid (harus HH:MM atau HH:MM:SS)'])->withInput();
                }
            } else {
                $data[$tf] = null;
            }
        }

        $question = Question::create([
            'tanggal' => $data['tanggal'],
            'nik' => $data['nik'],
            'nama' => $data['nama'],
            'no_hp' => $data['no_hp'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'kecamatan' => $data['kecamatan'] ?? null,
            'kelurahan' => $data['kelurahan'] ?? null,
            'jenis_layanan_id' => $data['jenis_layanan'] ?? null,
            'detail' => $data['detail'] ?? null,
            'jam_masuk' => $data['jam_masuk'] ?? null,
            'jam_di_balasan' => $data['jam_di_balasan'] ?? null,
        ]);

        return redirect()->route('questions.index')->with('status', 'Pertanyaan berhasil disimpan.');
    }

    /**
     * Show the form for editing the specified question.
     */
    public function edit(Question $question)
    {
        $categories = Category::all();
        return view('questions.edit', compact('question', 'categories'));
    }

    /**
     * Display the specified question.
     */
    public function show(Question $question)
    {
        $question->load('jenisLayanan');
        return view('questions.show', compact('question'));
    }

    /**
     * Return a small partial with question details (used by AJAX/modal).
     */
    public function detail(Question $question)
    {
        $question->load('jenisLayanan');
        return view('questions._detail', compact('question'));
    }

    /**
     * Update the specified question in storage.
     */
    public function update(Request $request, Question $question)
    {
        $data = $request->validate([
            'tanggal' => 'required|date',
            'nik' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'kecamatan' => 'nullable|string|max:255',
            'kelurahan' => 'nullable|string|max:255',
            'jenis_layanan' => 'nullable|exists:categories,id',
            'detail' => 'nullable|string',
            'jam_masuk' => 'nullable',
            'jam_di_balasan' => 'nullable',
        ]);

        // Normalize time formats: accept H:i or H:i:s and store as H:i
        foreach (['jam_masuk', 'jam_di_balasan'] as $tf) {
            if (!empty($request->input($tf))) {
                $val = $request->input($tf);
                try {
                    try {
                        $t = \Carbon\Carbon::createFromFormat('H:i', $val);
                    } catch (\Exception $e) {
                        $t = \Carbon\Carbon::createFromFormat('H:i:s', $val);
                    }
                    $data[$tf] = $t->format('H:i');
                } catch (\Exception $e) {
                    return redirect()->back()->withErrors([$tf => 'Format waktu tidak valid (harus HH:MM atau HH:MM:SS)'])->withInput();
                }
            } else {
                $data[$tf] = null;
            }
        }

        $question->update([
            'tanggal' => $data['tanggal'],
            'nik' => $data['nik'],
            'nama' => $data['nama'],
            'no_hp' => $data['no_hp'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'kecamatan' => $data['kecamatan'] ?? null,
            'kelurahan' => $data['kelurahan'] ?? null,
            'jenis_layanan_id' => $data['jenis_layanan'] ?? null,
            'detail' => $data['detail'] ?? null,
            'jam_masuk' => $data['jam_masuk'] ?? null,
            'jam_di_balasan' => $data['jam_di_balasan'] ?? null,
        ]);

        return redirect()->route('questions.index')->with('status', 'Pertanyaan berhasil diperbarui.');
    }

    /**
     * Remove the specified question from storage.
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('questions.index')->with('status', 'Pertanyaan berhasil dihapus.');
    }

    public function markReplied(Question $question)
    {
        $question->update([
            'jam_di_balasan' => now()->format('H:i'),
        ]);
        return redirect()->back()->with('status', 'Waktu balasan berhasil dicatat.');
    }

    public function checkNew(Request $request)
    {
    $lastId = (int) $request->query('last_id', 0);

    $hasNew = Question::where('id', '>', $lastId)->exists();
    $newCount = Question::where('id', '>', $lastId)->count();

    return response()->json([
        'hasNew' => $hasNew,
        'count' => $newCount,
    ]);
    }

    
}
