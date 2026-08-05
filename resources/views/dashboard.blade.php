<x-app-layout>
    <div class="pt-2 pb-10 bg-gray-50/50 min-h-screen">
        <div class="w-full mx-auto px-4 lg:px-6">

            {{-- 0. Welcome Section --}}
            <div class="mb-8 mt-4">
                <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-6 relative overflow-hidden transition-all hover:shadow-md group">
                    {{-- Dekorasi Latar Belakang --}}
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-blue-50/50 rounded-full blur-3xl animate-float"></div>
                    <div class="absolute -left-10 -top-10 w-32 h-32 bg-indigo-50/50 rounded-full blur-3xl animate-float-delayed"></div>

                    <div class="relative z-10">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="px-3 py-1 bg-blue-600 text-[9px] md:text-[10px] font-extrabold text-white uppercase tracking-widest rounded-full shadow-lg shadow-blue-200 animate-pulse">
                                Dashboard Utama
                            </span>
                        </div>
                        <h1 class="text-2xl md:text-3xl font-black text-gray-900 tracking-tight leading-tight">
                            Selamat Datang, <span class="text-blue-600">{{ Auth::user()->name ?? 'Admin' }}</span>! 👋
                        </h1>
                        <p class="text-sm md:text-base text-gray-500 font-medium mt-1">
                            Berikut adalah ringkasan aktivitas layanan <span class="font-bold text-gray-700">SAMPURASUN</span> di Disdukcapil Kota Bogor.
                        </p>
                    </div>
                    
                    {{-- Live Date Badge --}}
                    <div class="relative z-10 flex items-center gap-4 bg-gray-50/80 backdrop-blur-sm px-5 py-3.5 rounded-2xl border border-gray-100 w-fit self-start md:self-center transition-all hover:scale-105">
                        <div class="p-2.5 bg-white text-blue-600 rounded-xl shadow-sm border border-gray-100 group-hover:rotate-12 transition-transform duration-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">Tanggal Hari Ini</p>
                            <p class="text-base font-black text-gray-800 leading-tight">{{ now()->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 1. Dashboard Stats Grid --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    @php
        // Logika untuk mendapatkan rentang tanggal minggu ini (Senin - Minggu)
        $awalMinggu = now()->startOfWeek()->translatedFormat('d');
        $akhirMinggu = now()->endOfWeek()->translatedFormat('d M');
        $rentangMinggu = $awalMinggu . ' - ' . $akhirMinggu;

        $stats = [
            [
                'label' => 'Total Pertanyaan', 
                'value' => $questions, 
                'color' => 'blue', 
                'icon' => 'M13 7l5 5m0 0l-5 5m5-5H6', 
                'gradient' => 'from-blue-600 to-blue-400'
            ],
            [
                'label' => 'Kategori Layanan', 
                'value' => $categories, 
                'color' => 'indigo', 
                'icon' => 'M4 6h16M4 10h16M4 14h16M4 18h16', 
                'gradient' => 'from-indigo-600 to-indigo-400'
            ],
            [
                'label' => 'Chat Bulan Ini (' . now()->translatedFormat('F') . ')', 
                'value' => $chatsThisMonth, 
                'color' => 'emerald', 
                'icon' => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z', 
                'gradient' => 'from-emerald-600 to-emerald-400'
            ],
            [
                'label' => 'Minggu Ini (' . $rentangMinggu . ')', 
                'value' => $chatsThisWeek, 
                'color' => 'orange', 
                'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 
                'gradient' => 'from-orange-600 to-orange-400'
            ],
        ];
    @endphp

    @foreach($stats as $stat)
        <div class="stat-card bg-white rounded-[2rem] p-6 shadow-sm border border-gray-100 relative overflow-hidden group transition-all duration-500">
            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-5">
                    <div class="p-3.5 bg-{{ $stat['color'] }}-50 text-{{ $stat['color'] }}-600 rounded-2xl group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/>
                        </svg>
                    </div>
                    {{-- Tracking diubah ke wider agar teks tanggal yang panjang tidak menumpuk --}}
                    <p class="text-[10px] md:text-[11px] font-black text-gray-400 uppercase tracking-wider leading-tight">
                        {{ $stat['label'] }}
                    </p>
                </div>
                <div class="flex items-baseline gap-2">
                    <h2 class="text-4xl font-black text-gray-900 count-number tracking-tighter" data-target="{{ $stat['value'] }}">0</h2>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Data</span>
                </div>
                <div class="mt-5 w-full bg-gray-50 h-2 rounded-full overflow-hidden">
                    <div class="bg-gradient-to-r {{ $stat['gradient'] }} h-full w-2/3 rounded-full group-hover:w-full transition-all duration-1000"></div>
                </div>
            </div>
        </div>
    @endforeach
</div>

            {{-- 2. Charts Section --}}
            <div class="space-y-4">
                {{-- Line Chart Aktivitas --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 md:p-6">
                        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
                            <div>
                                <h3 class="text-sm md:text-base font-bold text-gray-800">Aktivitas Pertanyaan</h3>
                                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-tight">Tren frekuensi pertanyaan harian</p>
                            </div>
                            <div class="flex flex-wrap items-center gap-2 bg-gray-50 p-2 rounded-xl border border-gray-100">
                                <input type="date" id="dateFrom" class="text-[11px] border-gray-200 rounded-lg p-1.5 bg-white font-semibold text-gray-600">
                                <span class="text-[10px] font-bold text-gray-400 uppercase">S/D</span>
                                <input type="date" id="dateTo" class="text-[11px] border-gray-200 rounded-lg p-1.5 bg-white font-semibold text-gray-600">
                                <div class="flex gap-1.5">
                                    <button id="filterDateBtn" class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-lg transition-all active:scale-95">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                    </button>
                                    <button id="resetDateBtn" class="bg-rose-100 hover:bg-rose-200 text-rose-600 p-2 rounded-lg transition-all active:scale-95">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="relative h-[200px] md:h-[240px]">
                            <canvas id="last14Chart"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Bar Charts Kategori & Wilayah --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-5 md:p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm md:text-base font-bold text-gray-800">Kategori Terbanyak</h3>
                            <button id="toggleCategoriesBtn" class="text-[9px] md:text-[10px] font-bold text-blue-600 bg-blue-50 px-3 py-1.5 rounded-lg uppercase">
                                Lihat Semua
                            </button>
                        </div>
                        <div class="relative h-[250px] md:h-[320px]">
                            <canvas id="categoriesChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 md:p-6">
                        <h3 class="text-sm md:text-base font-bold text-gray-800 mb-4 text-center">Sebaran Wilayah</h3>
                        <div class="relative h-[250px] md:h-[320px]">
                            <canvas id="kecamatanChart"></canvas>
                        </div>
                        <p class="text-center text-[9px] text-gray-400 mt-4 italic font-medium">* Klik batang grafik untuk detail kelurahan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Detail Kelurahan --}}
    <div id="kelurahanModal" class="fixed inset-0 z-[100] flex items-end sm:items-center justify-center bg-gray-900/60 backdrop-blur-sm hidden p-0 sm:p-4">
        <div id="modalContainer" class="bg-white rounded-t-[2rem] sm:rounded-[2rem] w-full max-w-4xl overflow-hidden shadow-2xl transform transition-all translate-y-full sm:translate-y-0 sm:scale-95 opacity-0 duration-300 max-h-[90vh] flex flex-col">
            <div class="px-6 py-5 border-b border-gray-50 flex items-center justify-between shrink-0">
                <div>
                    <h3 class="text-base md:text-lg font-bold text-gray-900 flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span>
                        Detail Kelurahan
                    </h3>
                    <p id="kelurahanTitleSub" class="text-[10px] md:text-xs text-gray-400 font-bold uppercase tracking-wider">Kecamatan: -</p>
                </div>
                <button id="kelurahanModalClose" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-6 overflow-y-auto">
                <div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-6">
                    <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Filter Layanan:</label>
                    <select id="kelurahanCategorySelect" class="border-gray-200 rounded-xl text-xs focus:ring-blue-500 focus:border-blue-500 pr-8 w-full sm:w-auto font-bold text-gray-700">
                        <option value="">Semua Layanan</option>
                    </select>
                </div>
                <div class="relative h-[300px] w-full">
                    <canvas id="kelurahanChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Data awal dari PHP
            const initialLabels = {!! json_encode($last14Labels ?? []) !!};
            const initialCounts = {!! json_encode($last14Counts ?? []) !!};
            const fullCatLabels = {!! json_encode($categoryLabels ?? []) !!};
            const fullCatData = {!! json_encode($categoryCounts ?? []) !!};
            const kecLabels = {!! json_encode($kecamatanLabels ?? []) !!};
            const kecData = {!! json_encode($kecamatanCounts ?? []) !!};
            const categoriesList = {!! json_encode($categoriesList ?? []) !!};

            Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
            Chart.defaults.color = '#94a3b8';

            const getBlueGradient = (ctx) => {
                const gradient = ctx.createLinearGradient(0, 0, 0, 350);
                gradient.addColorStop(0, 'rgba(59, 130, 246, 0.4)'); 
                gradient.addColorStop(1, 'rgba(59, 130, 246, 0.01)'); 
                return gradient;
            };

            // 1. Line Chart (Activity)
            const ctx14 = document.getElementById('last14Chart').getContext('2d');
            let lineChart = new Chart(ctx14, {
                type: 'line',
                data: {
                    labels: initialLabels,
                    datasets: [{
                        data: initialCounts,
                        fill: true,
                        backgroundColor: getBlueGradient(ctx14),
                        borderColor: '#3b82f6',
                        borderWidth: 3,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#3b82f6',
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, ticks: { font: { size: 10, weight: 'bold' } } },
                        y: { beginAtZero: true, ticks: { precision: 0 } }
                    }
                }
            });

            // 2. Category Chart
            const ctxCat = document.getElementById('categoriesChart').getContext('2d');
            let showingAll = false;
            let catChart = new Chart(ctxCat, {
                type: 'bar',
                data: {
                    labels: fullCatLabels.slice(0, 10),
                    datasets: [{
                        data: fullCatData.slice(0, 10),
                        backgroundColor: getBlueGradient(ctxCat),
                        borderColor: '#3b82f6',
                        borderWidth: 1.5,
                        borderRadius: 8
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false, 
                    plugins: { legend: { display: false } } 
                }
            });

            // 3. Kecamatan Chart
            const ctxKec = document.getElementById('kecamatanChart').getContext('2d');
            new Chart(ctxKec, {
                type: 'bar',
                data: {
                    labels: kecLabels,
                    datasets: [{
                        data: kecData,
                        backgroundColor: getBlueGradient(ctxKec),
                        borderColor: '#3b82f6',
                        borderWidth: 1.5,
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    onClick: (e, elements) => {
                        if (elements.length > 0) {
                            const idx = elements[0].index;
                            openKelurahan(kecLabels[idx]);
                        }
                    }
                }
            });

            // FUNGSI FILTER REFRESH AKTIVITAS
            document.getElementById('filterDateBtn').onclick = async function() {
                const from = document.getElementById('dateFrom').value;
                const to = document.getElementById('dateTo').value;
                if (!from || !to) return;

                this.disabled = true;
                const originalIcon = this.innerHTML;
                this.innerHTML = `<svg class="w-4 h-4 animate-spin" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>`;

                try {
                    const res = await fetch(`/dashboard/activity?from=${from}&to=${to}`);
                    const result = await res.json();
                    lineChart.data.labels = result.labels;
                    lineChart.data.datasets[0].data = result.data;
                    lineChart.update();
                } finally {
                    this.disabled = false;
                    this.innerHTML = originalIcon;
                }
            };

            document.getElementById('resetDateBtn').onclick = function() {
                document.getElementById('dateFrom').value = '';
                document.getElementById('dateTo').value = '';
                lineChart.data.labels = initialLabels;
                lineChart.data.datasets[0].data = initialCounts;
                lineChart.update();
            };

            document.getElementById('toggleCategoriesBtn').onclick = function() {
                showingAll = !showingAll;
                catChart.data.labels = showingAll ? fullCatLabels : fullCatLabels.slice(0, 10);
                catChart.data.datasets[0].data = showingAll ? fullCatData : fullCatData.slice(0, 10);
                catChart.update();
                this.textContent = showingAll ? '10 Teratas' : 'Lihat Semua';
            };

            // MODAL KELURAHAN LOGIC
            const modal = document.getElementById('kelurahanModal');
            const container = document.getElementById('modalContainer');
            const selCat = document.getElementById('kelurahanCategorySelect');
            let currentKec = '';
            let kelChart = null;

            categoriesList.forEach(c => selCat.add(new Option(c.name, c.id)));

            async function openKelurahan(kec) {
                currentKec = kec;
                document.getElementById('kelurahanTitleSub').textContent = `Kecamatan: ${kec}`;
                modal.classList.remove('hidden');
                setTimeout(() => container.classList.remove('translate-y-full', 'opacity-0', 'sm:scale-95'), 10);
                updateKelurahanChart();
            }

            async function updateKelurahanChart() {
                const catId = selCat.value;
                const url = `/kecamatan/${encodeURIComponent(currentKec)}/kelurahan-data${catId ? `?category_id=${catId}` : ''}`;
                const res = await fetch(url);
                const payload = await res.json();
                
                const ctxKel = document.getElementById('kelurahanChart').getContext('2d');
                if (kelChart) kelChart.destroy();
                kelChart = new Chart(ctxKel, {
                    type: 'bar',
                    data: {
                        labels: payload.labels,
                        datasets: [{ data: payload.data, backgroundColor: getBlueGradient(ctxKel), borderColor: '#3b82f6', borderWidth: 1, borderRadius: 6 }]
                    },
                    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
                });
            }

            selCat.onchange = updateKelurahanChart;
            document.getElementById('kelurahanModalClose').onclick = () => {
                container.classList.add('translate-y-full', 'opacity-0', 'sm:scale-95');
                setTimeout(() => modal.classList.add('hidden'), 300);
            };

            // Animasi Angka
            document.querySelectorAll('.count-number').forEach(el => {
                const target = parseInt(el.dataset.target);
                let current = 0;
                const increment = target / 40;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        el.textContent = target.toLocaleString();
                        clearInterval(timer);
                    } else { el.textContent = Math.floor(current).toLocaleString(); }
                }, 25);
            });
        });
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-15px); } }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-delayed { animation: float 8s ease-in-out infinite 2s; }
        .stat-card:hover { transform: translateY(-8px); border-color: #3b82f6; box-shadow: 0 15px 30px -10px rgba(0,0,0,0.1); }
    </style>
</x-app-layout>