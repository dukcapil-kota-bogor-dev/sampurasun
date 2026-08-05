<div class="text-gray-800 bg-white rounded-lg">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 md:gap-x-8 md:gap-y-6 mb-6">
        
        <div class="border-b border-gray-100 pb-2 md:border-0 md:pb-0">
            <div class="text-[10px] md:text-xs text-gray-500 uppercase tracking-wider font-semibold">Tanggal</div>
            <div class="text-base md:text-lg font-bold text-gray-900">{{ $question->tanggal }}</div>
        </div>

        <div class="border-b border-gray-100 pb-2 md:border-0 md:pb-0">
            <div class="text-[10px] md:text-xs text-gray-500 uppercase tracking-wider font-semibold">NIK</div>
            <div class="text-base md:text-lg font-medium font-mono text-gray-700">{{ $question->nik }}</div>
        </div>

        <div class="border-b border-gray-100 pb-2 md:border-0 md:pb-0">
            <div class="text-[10px] md:text-xs text-gray-500 uppercase tracking-wider font-semibold">Nama</div>
            <div class="text-base md:text-lg font-bold text-gray-900 uppercase">{{ $question->nama }}</div>
        </div>

        <div class="border-b border-gray-100 pb-2 md:border-0 md:pb-0">
            <div class="text-[10px] md:text-xs text-gray-500 uppercase tracking-wider font-semibold">No HP</div>
            <div class="text-base md:text-lg font-medium text-blue-600">{{ $question->no_hp }}</div>
        </div>

        <div class="grid grid-cols-2 gap-4 md:contents">
            <div>
                <div class="text-[10px] md:text-xs text-gray-500 uppercase tracking-wider font-semibold">Jenis Kelamin</div>
                <div class="text-sm md:text-base">{{ $question->jenis_kelamin ?? '-' }}</div>
            </div>
            <div>
                <div class="text-[10px] md:text-xs text-gray-500 uppercase tracking-wider font-semibold">Jenis Layanan</div>
                <div class="text-sm md:text-base font-medium">{{ $question->jenisLayanan?->name ?? '-' }}</div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 md:contents border-t border-gray-100 pt-2 md:pt-0">
            <div>
                <div class="text-[10px] md:text-xs text-gray-500 uppercase tracking-wider font-semibold">Kecamatan</div>
                <div class="text-sm md:text-base">{{ $question->kecamatan ?? '-' }}</div>
            </div>
            <div>
                <div class="text-[10px] md:text-xs text-gray-500 uppercase tracking-wider font-semibold">Kelurahan</div>
                <div class="text-sm md:text-base">{{ $question->kelurahan ?? '-' }}</div>
            </div>
        </div>
    </div>

    <div class="mb-6">
        <div class="text-[10px] md:text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Detail Pertanyaan</div>
        <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg text-sm md:text-base leading-relaxed break-words whitespace-pre-wrap shadow-sm text-gray-700">
            {!! nl2br(e($question->detail ?? '-')) !!}
        </div>
    </div>

    <div class="grid grid-cols-3 gap-2 bg-blue-50 p-4 rounded-xl border border-blue-100">
        <div class="text-center md:text-left border-r border-blue-200 last:border-0">
            <div class="text-[10px] md:text-xs text-blue-600 uppercase font-bold mb-1">Masuk</div>
            <div class="text-sm md:text-base font-semibold">{{ $question->jam_masuk ?? '-' }}</div>
        </div>

        <div class="text-center md:text-left border-r border-blue-200 last:border-0">
            <div class="text-[10px] md:text-xs text-blue-600 uppercase font-bold mb-1">Balas</div>
            <div class="text-sm md:text-base font-semibold">{{ $question->jam_di_balasan ?? '-' }}</div>
        </div>

        <div class="text-center md:text-left">
            <div class="text-[10px] md:text-xs text-blue-600 uppercase font-bold mb-1">Selisih</div>
            <div class="text-sm md:text-base font-bold text-blue-700">
                @php
                    $selisih = '-';
                    if(!empty($question->jam_masuk) && !empty($question->jam_di_balasan)){
                        try {
                            $m = \Carbon\Carbon::parse($question->jam_masuk);
                            $b = \Carbon\Carbon::parse($question->jam_di_balasan);
                            $diff = $b->diff($m);
                            $hours = $diff->h + ($diff->d * 24);
                            $selisih = sprintf('%02d:%02d', $hours, $diff->i);
                        } catch (\Exception $e) {
                            $selisih = '-';
                        }
                    }
                @endphp
                {{ $selisih }}
            </div>
        </div>
    </div>
</div>