<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>SAMPURASUN - Disdukcapil Kota Bogor</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/Logo Dukcapil.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <script src="https://unpkg.com/lucide@latest"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root { --brand-primary: #4f46e5; --brand-secondary: #0ea5e9; }
        body { background-color: #ffffff; font-family: 'Figtree', sans-serif; scroll-behavior: smooth; }
        .nav-glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border-bottom: 1px solid #f1f5f9; }
        .hero-gradient { background: radial-gradient(circle at top right, #f8fafc, #ffffff); }
        
        /* Update Hero Image agar Full & Responsif */
        .hero-img-custom { 
            width: 100%;
            height: auto;
            aspect-ratio: 16 / 10; /* Memberikan kesan wide/layar lebar */
            object-fit: cover; 
            border-radius: 2.5rem; 
        }

        /* Animasi Card Statistik */
        .stat-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            opacity: 0;
            transform: translateY(20px);
        }
        .stat-card.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px -12px rgba(79, 70, 229, 0.15);
        }
        .icon-box {
            transition: all 0.3s ease;
        }
        .stat-card:hover .icon-box {
            transform: scale(1.1) rotate(5deg);
        }
        
        .pulse-soft {
            animation: pulse-dot 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; }
            50% { opacity: .5; }
        }
    </style>
</head>
<body class="antialiased text-slate-900">

    <nav class="sticky top-0 z-50 nav-glass">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/Logo Dukcapil.png') }}" class="h-10 w-auto" alt="Logo Disdukcapil Kota Bogor">
                <div class="flex flex-col">
                    <span class="text-xl font-black tracking-tighter text-slate-800 leading-none">SAMPURASUN</span>
                    <span class="text-[9px] font-extrabold text-indigo-500 uppercase tracking-[0.3em]">Disdukcapil Kota Bogor</span>
                </div>
            </div>
            
            <div class="flex items-center gap-8 text-sm font-bold text-slate-600">
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-6 py-2 bg-slate-900 text-white rounded-xl hover:bg-black transition shadow-lg shadow-slate-200">DASHBOARD</a>
                @else
                    <a href="{{ route('login') }}" class="px-6 py-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">LOGIN</a>
                @endauth
            </div>
        </div>
    </nav>

    <section class="hero-gradient pt-16 pb-24 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-5">
                <h1 class="text-5xl lg:text-7xl font-black text-slate-900 leading-[1.1] mb-6 tracking-tight">
                    Transparansi <br><span class="text-indigo-600">Data Layanan</span> Penduduk.
                </h1>
                <p class="text-lg text-slate-500 font-medium mb-10 max-w-lg leading-relaxed">
                    Sistem Aplikasi Mobile Pelayanan Online (SAMPURASUN) memudahkan memantau statistik dan efektivitas layanan kependudukan secara real-time.
                </p>
            </div>

            <div class="relative lg:col-span-7 flex justify-center lg:justify-end">
                <div class="absolute -z-10 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[110%] h-[110%] bg-indigo-50/50 rounded-full blur-3xl"></div>
                <img src="{{ asset('images/depan capil.jpeg') }}" class="hero-img-custom shadow-2xl" alt="Kantor Disdukcapil Kota Bogor">
            </div>
        </div>
    </section>

    <section id="statistik" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-black text-slate-900 mb-4">Statistik Layanan Hari Ini</h2>
                <div class="w-20 h-1.5 bg-indigo-600 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <div class="stat-card bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col items-center text-center relative overflow-hidden group">
                    <div class="icon-box p-4 bg-indigo-50 text-indigo-600 rounded-2xl mb-4 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                        <i data-lucide="layers" class="w-8 h-8"></i>
                    </div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Permohonan</p>
                    <h3 class="count-up text-5xl font-black text-slate-900 mb-2" data-target="{{ $totalQuestions ?? 0 }}">0</h3>
                    <div class="text-[10px] font-bold py-1 px-3 bg-emerald-100 text-emerald-700 rounded-full uppercase">Sepanjang Waktu</div>
                </div>

                <div class="stat-card bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col items-center text-center relative overflow-hidden group" style="transition-delay: 100ms;">
                    <div class="icon-box p-4 bg-blue-50 text-blue-600 rounded-2xl mb-4 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                        <i data-lucide="calendar-range" class="w-8 h-8"></i>
                    </div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Bulan Ini</p>
                    <h3 class="count-up text-5xl font-black text-slate-900 mb-2" data-target="{{ $chatsThisMonth ?? 0 }}">0</h3>
                    <div class="text-[10px] font-bold py-1 px-3 bg-blue-100 text-blue-700 rounded-full uppercase">Update Bulanan</div>
                </div>

                <div class="stat-card bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col items-center text-center relative overflow-hidden group" style="transition-delay: 200ms;">
                    <div class="icon-box p-4 bg-violet-50 text-violet-600 rounded-2xl mb-4 group-hover:bg-violet-600 group-hover:text-white transition-colors duration-300">
                        <i data-lucide="trending-up" class="w-8 h-8"></i>
                    </div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Minggu Ini</p>
                    <h3 class="count-up text-5xl font-black text-slate-900 mb-2" data-target="{{ $chatsThisWeek ?? 0 }}">0</h3>
                    <div class="text-[10px] font-bold py-1 px-3 bg-violet-100 text-violet-700 rounded-full uppercase">Tren Mingguan</div>
                </div>
            </div>

            <div class="bg-white rounded-[3rem] border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 pt-10 pb-2 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-xl font-black text-slate-800">Tren Aktivitas 14 Hari Terakhir</h3>
                        <p class="text-sm text-slate-500 font-medium">Visualisasi frekuensi layanan kependudukan</p>
                    </div>
                    <div class="flex items-center gap-2 px-4 py-2 bg-indigo-50 rounded-full w-fit">
                        <span class="w-2.5 h-2.5 bg-indigo-600 rounded-full pulse-soft"></span>
                        <span class="text-[10px] font-bold text-indigo-700 uppercase tracking-wider">Data Terkini</span>
                    </div>
                </div>

                <div class="p-8 md:p-10">
                    <div class="h-[400px] chart-container">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();

            const ctxLine = document.getElementById('lineChart').getContext('2d');
            const gradient = ctxLine.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(79, 70, 229, 0.25)');
            gradient.addColorStop(0.5, 'rgba(79, 70, 229, 0.05)');
            gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');

            const labels = {!! json_encode($chartLabels ?? []) !!};
            const dataPoints = {!! json_encode($chartData ?? []) !!};

            new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: labels.length ? labels : ['No Data'],
                    datasets: [{
                        label: 'Permohonan',
                        data: dataPoints.length ? dataPoints : [0],
                        borderColor: '#4f46e5',
                        borderWidth: 4,
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#4f46e5',
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#f1f5f9' }, border: { display: false } },
                        x: { grid: { display: false }, border: { display: false } }
                    }
                }
            });

            const observerOptions = { threshold: 0.2 };
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if(entry.isIntersecting) {
                        if(entry.target.classList.contains('stat-card')) {
                            entry.target.classList.add('visible');
                        }
                        
                        if(entry.target.classList.contains('count-up')) {
                            const el = entry.target;
                            const target = +el.dataset.target;
                            const duration = 2000;
                            let start = null;

                            const step = (ts) => {
                                if (!start) start = ts;
                                const progress = Math.min((ts - start) / duration, 1);
                                el.textContent = Math.floor(progress * target).toLocaleString();
                                if (progress < 1) requestAnimationFrame(step);
                            };
                            requestAnimationFrame(step);
                        }
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.stat-card, .count-up').forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>