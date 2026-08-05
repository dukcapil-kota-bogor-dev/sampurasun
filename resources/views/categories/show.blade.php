<x-app-layout>
    {{-- Container Utama --}}
    <div class="pt-2 pb-10 bg-gray-50/50 min-h-screen">
        <div class="max-w-full mx-auto px-2 sm:px-4 lg:px-6">
            <div class="bg-white shadow-sm sm:rounded-lg border border-gray-100 overflow-hidden">
                <div class="p-4 md:p-6 bg-white border-b border-gray-200">
                    
                    {{-- Header Section --}}
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                        <div>
                            <h1 class="text-xl font-extrabold text-gray-800 tracking-tight uppercase">Kategori: {{ $category->name }}</h1>
                            <p class="text-sm text-gray-500 font-medium">Total data dalam kategori ini: <span class="text-indigo-600 font-bold">{{ $questions->total() }}</span></p>
                        </div>
                        <div class="flex items-center">
                            <a href="{{ route('categories.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-bold transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                                Kembali
                            </a>
                        </div>
                    </div>

                    {{-- Filter Form (Konsisten dengan Gaya Pencarian) --}}
                    <form method="GET" action="{{ route('categories.show', $category->id) }}" class="mb-6 flex flex-wrap items-end gap-3 p-4 bg-gray-50 rounded-xl border border-gray-200 shadow-sm">
                        <div class="flex-grow md:flex-none w-full md:w-64">
                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest block mb-1 ml-1">Kecamatan</label>
                            <select name="kecamatan" id="kecamatan_filter" class="w-full border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 font-bold text-gray-700">
                                <option value="">-- Semua Kecamatan --</option>
                                @foreach(($kecamatans ?? []) as $kec)
                                    <option value="{{ $kec }}" {{ (isset($selectedKecamatan) && $selectedKecamatan == $kec) ? 'selected' : '' }}>{{ $kec }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex-grow md:flex-none w-full md:w-64">
                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest block mb-1 ml-1">Kelurahan</label>
                            <select name="kelurahan" id="kelurahan_filter" class="w-full border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 font-bold text-gray-700">
                                <option value="">-- Semua Kelurahan --</option>
                                @foreach(($kelurahans ?? []) as $kel)
                                    <option value="{{ $kel }}" {{ (isset($selectedKelurahan) && $selectedKelurahan == $kel) ? 'selected' : '' }}>{{ $kel }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center gap-2 w-full md:w-auto">
                            <button type="submit" class="flex-grow md:flex-none px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-bold shadow-sm transition">
                                Cari
                            </button>
                            @if(request()->hasAny(['kecamatan','kelurahan']))
                                <a href="{{ route('categories.show', $category->id) }}" class="px-3 py-2 text-rose-600 bg-rose-50 hover:bg-rose-100 rounded-lg transition text-sm font-bold">Reset</a>
                            @endif
                        </div>
                    </form>

                    {{-- Area Tabel dengan Horizontal Scroll (Sama dengan Daftar Pertanyaan) --}}
                    <div class="border border-gray-200 rounded-lg overflow-x-auto custom-scrollbar">
                        <table class="w-full divide-y divide-gray-200 min-w-[900px]">
                            <thead class="bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                <tr>
                                    <th class="px-4 py-4 text-center">Tanggal</th>
                                    <th class="px-4 py-4">Identitas</th>
                                    <th class="px-4 py-4">No. HP</th>
                                    <th class="px-4 py-4">Wilayah</th>
                                    <th class="px-4 py-4">Layanan</th>
                                    <th class="px-4 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100 text-sm font-semibold text-gray-700">
                                @forelse($questions as $q)
                                    <tr class="hover:bg-indigo-50/30 transition-colors">
                                        <td class="px-4 py-4 whitespace-nowrap text-gray-500 font-medium text-center uppercase tracking-tighter italic">
                                            {{ $q->tanggal }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <div class="font-bold text-gray-900 text-base leading-tight">{{ $q->nama }}</div>
                                            <div class="text-[13px] text-gray-500 font-mono tracking-tight font-semibold mt-0.5 bg-gray-50 px-1 rounded inline-block">
                                                {{ $q->nik }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap font-bold text-indigo-600 italic">
                                            {{ $q->no_hp ?? '-' }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap leading-tight">
                                            <div class="font-bold uppercase text-gray-600 text-xs">{{ $q->kecamatan ?? '-' }}</div>
                                            <div class="text-gray-400 font-medium text-[11px] italic">{{ $q->kelurahan ?? '-' }}</div>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <span class="px-2 py-0.5 bg-indigo-50 text-indigo-700 rounded text-[11px] font-bold uppercase ring-1 ring-indigo-100">
                                                {{ $q->jenisLayanan?->name ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <div class="flex justify-center items-center">
                                                <button data-id="{{ $q->id }}" class="category-open-detail p-1.5 text-emerald-600 hover:bg-emerald-50 rounded-md transition-all" title="Lihat Detail">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-12 text-center text-gray-400 font-bold uppercase text-xs tracking-widest">Belum ada data untuk filter ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-5 font-bold">
                        {{ $questions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail Modal --}}
    <div id="categoryQuestionDetailModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-xl overflow-hidden transform transition-all">
            <div class="px-5 py-3 bg-gray-50 border-b flex justify-between items-center text-sm">
                <h3 class="font-bold text-gray-700 uppercase tracking-tighter">Informasi Detail Pertanyaan</h3>
                <button id="categoryQuestionDetailClose" class="text-gray-400 hover:text-rose-500 text-2xl font-bold transition-colors">&times;</button>
            </div>
            <div id="categoryQuestionDetailContent" class="p-6 overflow-y-auto max-h-[70vh] text-sm text-gray-700 leading-relaxed font-semibold"></div>
            <div class="px-5 py-3 bg-gray-50 text-right">
                <button id="categoryQuestionDetailCloseFooter" class="px-5 py-2 bg-white border border-gray-300 rounded font-bold text-xs text-gray-600 hover:bg-gray-100 shadow-sm transition">Tutup</button>
            </div>
        </div>
    </div>

    {{-- Custom Styles (Sama dengan Daftar Pertanyaan) --}}
    <style>
        body { overflow-x: hidden; }
        .custom-scrollbar::-webkit-scrollbar { height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>

    {{-- Script Logika --}}
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            const modal = document.getElementById('categoryQuestionDetailModal');
            const contentEl = document.getElementById('categoryQuestionDetailContent');
            const closeDetail = () => modal.classList.add('hidden');

            // Logika Fetch Detail
            async function fetchDetail(id){
                contentEl.innerHTML = `<div class="text-center py-6 text-sm font-semibold animate-pulse text-indigo-500 uppercase tracking-widest">Memuat...</div>`;
                try {
                    const url = window.baseUrl + `/questions/${id}/detail`;                    
                    const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                    if (!res.ok) throw new Error();
                    const html = await res.text();
                    contentEl.innerHTML = html;
                } catch (e) {
                    contentEl.innerHTML = '<div class="text-sm text-red-500 text-center font-bold">Gagal memuat data detail.</div>';
                }
            }

            document.querySelectorAll('.category-open-detail').forEach(btn => {
                btn.addEventListener('click', function(){
                    const id = btn.getAttribute('data-id');
                    if (!id) return;
                    modal.classList.remove('hidden');
                    fetchDetail(id);
                });
            });

            document.getElementById('categoryQuestionDetailClose').onclick = closeDetail;
            document.getElementById('categoryQuestionDetailCloseFooter').onclick = closeDetail;
            modal.onclick = (e) => { if (e.target == modal) closeDetail(); };

            // Logika Dependent Dropdown Wilayah
            const kelurahansMap = {
                'Bogor Utara': ['Bantarjati','Cibuluh','Ciluar','Cimahpar','Ciparigi','Kedunghalang','Tanahbaru','Tegal Gundil'],
                'Bogor Timur': ['Baranangsiang','Katulampa','Sindangrasa','Sindangsari','Sukasari','Tajur'],
                'Bogor Tengah': ['Babakan','Babakan Pasar','Cibogor','Ciwaringin','Gudang','Kebon Kelapa','Pabaton','Paledang','Panaragan','Sempur','Tegallega'],
                'Bogor Barat': ['Balumbang Jaya','Bubulak','Cilendek Barat','Cilendek Timur','Curug','Curugmekar','Gunungbatu','Loji','Margajaya','Menteng','Pasirjaya','Pasirkuda','Pasirmulya','Semplak','Sindangbarang','Situgede'],
                'Bogor Selatan': ['Batutulis','Bojongkerta','Bondongan','Cikaret','Cipaku','Empang','Genteng','Harjasari','Kertamaya','Lawanggintung','Muarasari','Mulyaharja','Pakuan','Pamoyanan','Rancamaya','Ranggamekar'],
                'Tanah Sareal': ['Tanah Sareal','Kebonpedes','Kedungbadak','Kedungjaya','Kedungwaringin','Cibadak','Kayumanis','Mekarwangi','Kencana','Sukadamai','Sukaresmi']
            };

            const kecSelect = document.getElementById('kecamatan_filter');
            const kelSelect = document.getElementById('kelurahan_filter');
            const selectedKel = @json($selectedKelurahan ?? '');

            function populateKelurahan(kecamatan) {
                if (!kelSelect) return;
                kelSelect.innerHTML = '<option value="">-- Semua Kelurahan --</option>';
                let list = kecamatan ? (kelurahansMap[kecamatan] || []) : [];
                list.forEach(function(kel) {
                    const opt = document.createElement('option');
                    opt.value = kel;
                    opt.textContent = kel;
                    if(kel === selectedKel) opt.selected = true;
                    kelSelect.appendChild(opt);
                });
            }

            if (kecSelect) {
                populateKelurahan(kecSelect.value);
                kecSelect.addEventListener('change', function() {
                    populateKelurahan(this.value);
                });
            }
        });
    </script>
</x-app-layout>