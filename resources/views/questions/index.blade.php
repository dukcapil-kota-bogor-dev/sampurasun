<x-app-layout>
    {{-- Container Utama --}}
    <div class="pt-6 pb-12 bg-gray-50/50 min-h-screen font-['Plus_Jakarta_Sans']">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- 1. HEADER SECTION --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 animate-slide-up">
                <div>
                    <h1 class="text-3xl font-black text-gray-900 tracking-tight">Daftar Pertanyaan</h1>
                    <p class="text-sm md:text-base text-gray-500 font-medium mt-1">
                        Manajemen data layanan <span class="text-indigo-600 font-bold underline decoration-indigo-200 decoration-2">SAMPURASUN</span> Disdukcapil Kota Bogor.
                    </p>
                </div>

                <a href="{{ route('questions.create') }}" class="inline-flex items-center justify-center px-6 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-sm font-bold shadow-xl shadow-indigo-100 transition-all active:scale-95 shrink-0 group">
                    <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Data Baru
                </a>
            </div>

            {{-- 2. FILTER & SEARCH BOX --}}
            <div class="bg-white p-4 md:p-5 rounded-[2rem] border border-gray-100 shadow-sm mb-6 transition-all hover:shadow-md animate-slide-up" style="animation-delay: 0.1s">
                <form method="GET" action="{{ route('questions.index') }}" class="flex flex-col lg:flex-row items-center gap-4">
                    <div class="flex flex-col md:flex-row items-center bg-gray-50 border border-gray-100 rounded-2xl overflow-hidden flex-grow w-full focus-within:ring-2 focus-within:ring-indigo-500/20 transition-all">
                        {{-- Filter Tanggal --}}
                        <div class="flex items-center px-4 py-3 border-b md:border-b-0 md:border-r border-gray-100 w-full md:w-auto bg-white/50">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <input type="date" name="date" value="{{ request('date') }}" class="text-sm bg-transparent border-none focus:ring-0 text-gray-600 font-bold cursor-pointer w-full" />
                        </div>

                        {{-- Input Nama/NIK --}}
                        <div class="flex items-center px-4 py-3 flex-grow w-full bg-white/50">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari Nama atau NIK Pemohon..." class="text-sm bg-transparent border-none focus:ring-0 w-full font-semibold text-gray-700 placeholder-gray-400" />
                        </div>
                    </div>

                    <div class="flex items-center gap-2 w-full lg:w-auto">
                        <button type="submit" class="flex-grow lg:flex-grow-0 px-8 py-3.5 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 transition-all font-black text-xs uppercase tracking-widest rounded-2xl active:scale-95">
                            Cari Data
                        </button>

                        @if(request()->hasAny(['q','date']))
                            <a href="{{ route('questions.index') }}" class="p-3.5 text-rose-600 bg-rose-50 hover:bg-rose-100 rounded-2xl transition-all shadow-sm active:scale-95" title="Reset Filter">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- 3. Notifikasi Status --}}
            @if(session('status'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-2xl text-sm font-bold flex items-center shadow-sm animate-fade-in">
                    <svg class="w-5 h-5 mr-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ session('status') }}
                </div>
            @endif

            {{-- 4. TABLE DATA BOX --}}
            <div class="bg-white border border-gray-100 rounded-[2.5rem] shadow-sm overflow-hidden transition-all hover:shadow-md animate-slide-up" style="animation-delay: 0.2s">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full divide-y divide-gray-50 min-w-[950px]">
                        <thead class="bg-gray-50/50 text-left">
                            <tr>
                                <th class="px-6 py-6 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Tanggal</th>
                                <th class="px-6 py-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Identitas Pemohon</th>
                                <th class="px-6 py-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">No. WhatsApp</th>
                                <th class="px-6 py-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Jenis Layanan</th>
                                <th class="px-6 py-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Wilayah</th>
                                <th class="px-6 py-6 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($questions as $index => $q)
                                <tr class="hover:bg-gray-50/50 transition-colors group animate-slide-up" style="animation-delay: {{ 0.1 + ($index * 0.05) }}s">
                                    <td class="px-6 py-5 text-center whitespace-nowrap">
                                        <span class="text-gray-400 font-bold text-xs italic">{{ $q->tanggal }}</span>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="font-black text-gray-900 text-base tracking-tight leading-none group-hover:text-indigo-600 transition-colors">{{ $q->nama }}</div>
                                        <div class="text-[11px] text-gray-400 font-mono mt-2 flex items-center font-bold">
                                            <span class="bg-gray-100 px-1.5 py-0.5 rounded mr-1 tracking-tighter text-[9px] text-gray-500 uppercase">nik</span> {{ $q->nik }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <span class="font-black text-indigo-600 italic tracking-tighter">{{ $q->no_hp ?? '-' }}</span>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <span class="px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full text-[10px] font-black ring-1 ring-indigo-100 uppercase tracking-tighter">
                                            {{ $q->jenisLayanan?->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap leading-tight">
                                        <div class="font-black uppercase text-gray-700 text-[11px]">{{ $q->kecamatan ?? '-' }}</div>
                                        <div class="text-gray-400 font-bold text-[10px] italic lowercase opacity-70">{{ $q->kelurahan ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="flex justify-center items-center space-x-2">
                                            <button data-id="{{ $q->id }}" class="open-detail-btn p-2.5 text-emerald-600 hover:bg-emerald-50 hover:scale-110 rounded-xl transition-all shadow-sm bg-white border border-emerald-100" title="Detail">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </button>
                                            <a href="{{ route('questions.edit', $q->id) }}" class="p-2.5 text-amber-600 hover:bg-amber-50 hover:scale-110 rounded-xl transition-all shadow-sm bg-white border border-amber-100" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </a>
                                            <form action="{{ route('questions.destroy', $q->id) }}" method="POST" class="delete-question-form inline" data-name="{{ $q->nama }}" data-nik="{{ $q->nik }}">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2.5 text-rose-600 hover:bg-rose-50 hover:scale-110 rounded-xl transition-all shadow-sm bg-white border border-rose-100" title="Hapus">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-20 text-center">
                                        <div class="bg-gray-50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 border border-gray-100">
                                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <span class="text-gray-400 font-black uppercase text-[10px] tracking-widest">Data Tidak Ditemukan</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-50">
                    {{ $questions->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- 5. MODALS SECTION --}}
    
    {{-- Modal Detail --}}
    <div id="questionDetailModal" class="fixed inset-0 z-[60] flex items-center justify-center bg-gray-900/60 backdrop-blur-sm hidden p-4 opacity-0 transition-opacity duration-300">
        <div class="modal-content bg-white rounded-[2.5rem] shadow-2xl w-full max-w-xl overflow-hidden transform scale-90 transition-transform duration-300">
            <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center bg-white">
                <h3 class="font-black text-gray-800 uppercase text-xs tracking-[0.2em]">Informasi Detail</h3>
                <button id="questionDetailClose" class="text-gray-400 hover:text-rose-500 text-3xl font-light transition-colors leading-none">&times;</button>
            </div>
            <div id="questionDetailContent" class="p-8 overflow-y-auto max-h-[70vh] text-sm text-gray-700 font-semibold leading-relaxed"></div>
            <div class="px-8 py-5 bg-gray-50/50 text-right">
                <button id="questionDetailCloseFooter" class="px-6 py-2.5 bg-white border border-gray-200 rounded-xl font-bold text-xs text-gray-600 hover:bg-gray-100 shadow-sm transition-all uppercase tracking-widest active:scale-95">Tutup</button>
            </div>
        </div>
    </div>

    {{-- Modal Delete --}}
    <div id="deleteConfirmModal" class="fixed inset-0 z-[60] flex items-center justify-center bg-gray-900/60 backdrop-blur-sm hidden p-4 opacity-0 transition-opacity duration-300">
        <div class="modal-content bg-white rounded-[2.5rem] shadow-2xl w-full max-w-xs p-8 transform scale-90 transition-transform duration-300 text-center">
            <div class="w-16 h-16 bg-rose-50 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h3 class="text-lg font-black text-gray-900 uppercase tracking-tighter">Hapus Data?</h3>
            <div class="mt-4 p-4 bg-rose-50/50 rounded-2xl border border-rose-100/50 mb-6">
                <div id="delName" class="font-black text-rose-900 text-sm uppercase"></div>
                <div id="delNik" class="text-[12px] text-rose-700/70 mt-1 font-mono tracking-wider font-bold italic"></div>
            </div>
            <div class="flex gap-3">
                <button id="deleteCancelBtn" class="flex-1 py-3 bg-gray-100 text-gray-600 rounded-xl text-[10px] font-black hover:bg-gray-200 transition uppercase tracking-widest active:scale-95">Batal</button>
                <form id="deleteConfirmForm" method="POST" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full py-3 bg-rose-600 text-white rounded-xl text-[10px] font-black hover:bg-rose-700 transition shadow-lg shadow-rose-100 uppercase tracking-widest active:scale-95">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        
        body { overflow-x: hidden; letter-spacing: -0.01em; }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .animate-slide-up {
            opacity: 0;
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .animate-fade-in {
            animation: fadeIn 0.4s ease-out forwards;
        }

        .custom-scrollbar::-webkit-scrollbar { height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        
        /* Modal Animation Helpers */
        .modal-show { opacity: 1 !important; display: flex !important; }
        .modal-content-show { transform: scale(1) !important; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Modal Animation Utility
            function showModal(modalEl) {
                modalEl.classList.remove('hidden');
                setTimeout(() => {
                    modalEl.classList.add('modal-show');
                    modalEl.querySelector('.modal-content').classList.add('modal-content-show');
                }, 10);
            }

            function hideModal(modalEl) {
                modalEl.classList.remove('modal-show');
                modalEl.querySelector('.modal-content').classList.remove('modal-content-show');
                setTimeout(() => modalEl.classList.add('hidden'), 300);
            }

            // Logic Detail
            const detailModal = document.getElementById('questionDetailModal');
            const detailContent = document.getElementById('questionDetailContent');
            const detailCloseBtns = [document.getElementById('questionDetailClose'), document.getElementById('questionDetailCloseFooter')];

            function openDetail(id) {
                detailContent.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-12">
                        <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-indigo-600 mb-4"></div>
                        <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Memuat Data...</p>
                    </div>`;
                showModal(detailModal);
                
                fetch(`{{ url('/questions') }}/${id}/detail`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(r => r.text())
                    .then(h => { detailContent.innerHTML = h; })
                    .catch(() => { detailContent.innerHTML = `<p class="text-rose-500 text-center font-black uppercase text-[10px]">Gagal memuat data.</p>`; });
            }

            document.querySelectorAll('.open-detail-btn').forEach(btn => {
                btn.addEventListener('click', () => openDetail(btn.getAttribute('data-id')));
            });

            detailCloseBtns.forEach(btn => btn.addEventListener('click', () => hideModal(detailModal)));

            // Logic Delete
            const deleteModal = document.getElementById('deleteConfirmModal');
            document.querySelectorAll('.delete-question-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    document.getElementById('delName').textContent = form.getAttribute('data-name');
                    document.getElementById('delNik').textContent = 'NIK: ' + form.getAttribute('data-nik');
                    document.getElementById('deleteConfirmForm').action = form.action;
                    showModal(deleteModal);
                });
            });

            document.getElementById('deleteCancelBtn').onclick = () => hideModal(deleteModal);

            // Close Modals on click outside
            window.onclick = (e) => {
                if (e.target == detailModal) hideModal(detailModal);
                if (e.target == deleteModal) hideModal(deleteModal);
            }
        });
    </script>
</x-app-layout>