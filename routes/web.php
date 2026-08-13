<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

// Public homepage at root: render the same home view with latest questions
Route::get('/', function () {
    $questions = collect();

    if (Schema::hasTable('questions')) {
        $questions = \App\Models\Question::with('jenisLayanan')
            ->orderByDesc('created_at')
            ->paginate(15);
    }

    // Prepare dashboard-style counts and charts so the public homepage shows the same data
    $totalQuestions = Schema::hasTable('questions') ? DB::table('questions')->count() : 0;

    $chatsThisMonth = 0;
    $chatsThisWeek = 0;
    if (Schema::hasTable('questions')) {
        $now = now();
        $startOfMonth = $now->copy()->startOfMonth();
        $startOfWeek = $now->copy()->startOfWeek();

        $chatsThisMonth = DB::table('questions')->whereBetween('created_at', [$startOfMonth, $now])->count();
        $chatsThisWeek = DB::table('questions')->whereBetween('created_at', [$startOfWeek, $now])->count();
    }

    // Category stats for bar chart
    $categoryLabels = collect();
    $categoryCounts = collect();
    if (Schema::hasTable('categories') && Schema::hasTable('questions')) {
        $categoryStats = DB::table('categories')
            ->leftJoin('questions', 'categories.id', '=', 'questions.jenis_layanan_id')
            ->select('categories.name', DB::raw('count(questions.id) as count'))
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('count')
            ->get();

        $categoryLabels = $categoryStats->pluck('name')->values()->all();
        $categoryCounts = $categoryStats->pluck('count')->values()->all();
    }

    // Last 14 days data for line chart
    $chartLabels = [];
    $chartData = [];
    if (Schema::hasTable('questions')) {
        $today = now()->startOfDay();
        for ($i = 13; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
            $label = $date->format('d M');
            $start = $date->copy()->startOfDay();
            $end = $date->copy()->endOfDay();
            $count = DB::table('questions')->whereBetween('created_at', [$start, $end])->count();
            $chartLabels[] = $label;
            $chartData[] = $count;
        }
    }

    $barLabels = $categoryLabels;
    $barData = $categoryCounts;

    // Kecamatan stats for kecamatan chart
    $kecamatanLabels = [];
    $kecamatanCounts = [];
    if (Schema::hasTable('questions')) {
        $kecamatanStats = DB::table('questions')
            ->select('kecamatan', DB::raw('count(*) as count'))
            ->whereNotNull('kecamatan')
            ->where('kecamatan', '<>', '')
            ->groupBy('kecamatan')
            ->orderByDesc('count')
            ->get();

        $kecamatanLabels = $kecamatanStats->pluck('kecamatan')->values()->all();
        $kecamatanCounts = $kecamatanStats->pluck('count')->values()->all();

        if (!in_array('Ludo', $kecamatanLabels)) {
            $kecamatanLabels[] = 'Ludo';
            $kecamatanCounts[] = 0;
        }
    }

    return view('home', compact('questions', 'totalQuestions', 'chatsThisMonth', 'chatsThisWeek', 'chartLabels', 'chartData', 'barLabels', 'barData', 'kecamatanLabels', 'kecamatanCounts'));
})->name('home');

Route::get('/dashboard', function () {
    $questions = Schema::hasTable('questions') ? DB::table('questions')->count() : 0;

    // Count categories from the database so dashboard matches the Kategori Layanan page
    $categories = Schema::hasTable('categories') ? DB::table('categories')->count() : 0;

    // Category statistics: name + number of questions per category
    $categoryStats = [];
    if (Schema::hasTable('categories') && Schema::hasTable('questions')) {
        $categoryStats = DB::table('categories')
            ->leftJoin('questions', 'categories.id', '=', 'questions.jenis_layanan_id')
            ->select('categories.name', DB::raw('count(questions.id) as count'))
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('count')
            ->get();
    }

    $categoryLabels = $categoryStats ? $categoryStats->pluck('name') : collect();
    $categoryCounts = $categoryStats ? $categoryStats->pluck('count') : collect();

    // Full categories list for dashboard filters
    $categoriesList = Schema::hasTable('categories') ? DB::table('categories')->select('id','name')->orderBy('name')->get() : collect();

    // Chat counts: this month and this week (based on created_at)
    $chatsThisMonth = 0;
    $chatsThisWeek = 0;
    if (Schema::hasTable('questions')) {
        $now = now();
        $startOfMonth = $now->copy()->startOfMonth();
        $startOfWeek = $now->copy()->startOfWeek();

        $chatsThisMonth = DB::table('questions')->whereBetween('created_at', [$startOfMonth, $now])->count();
        $chatsThisWeek = DB::table('questions')->whereBetween('created_at', [$startOfWeek, $now])->count();
    }

    // Simple list of kecamatans for the dashboard sidebar card
    $kecamatanList = [];
    if (Schema::hasTable('questions')) {
        $kecamatanList = DB::table('questions')->select('kecamatan')->distinct()->whereNotNull('kecamatan')->pluck('kecamatan')->filter()->values()->all();
    }

    // Kecamatan statistics: name + number of questions per kecamatan
    $kecamatanStats = [];
    $kecamatanLabels = collect();
    $kecamatanCounts = collect();
    if (Schema::hasTable('questions')) {
        $kecamatanStats = DB::table('questions')
            ->select('kecamatan', DB::raw('count(*) as count'))
            ->whereNotNull('kecamatan')
            ->where('kecamatan', '<>', '')
            ->groupBy('kecamatan')
            ->orderByDesc('count')
            ->get();

        $kecamatanLabels = $kecamatanStats->pluck('kecamatan');
        $kecamatanCounts = $kecamatanStats->pluck('count');

        // Normalize to arrays and ensure 'Ludo' appears even when there are no records yet
        $kecamatanLabels = is_array($kecamatanLabels) ? $kecamatanLabels : $kecamatanLabels->values()->all();
        $kecamatanCounts = is_array($kecamatanCounts) ? $kecamatanCounts : $kecamatanCounts->values()->all();
        if (!in_array('Ludo', $kecamatanLabels)) {
            $kecamatanLabels[] = 'Ludo';
            $kecamatanCounts[] = 0;
        }
    }

    // Last 14 days: labels and counts for activity chart
    $last14Labels = [];
    $last14Counts = [];
    if (Schema::hasTable('questions')) {
        $today = now()->startOfDay();
        for ($i = 13; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
            $label = $date->format('d M');
            $start = $date->copy()->startOfDay();
            $end = $date->copy()->endOfDay();
            $count = DB::table('questions')->whereBetween('created_at', [$start, $end])->count();
            $last14Labels[] = $label;
            $last14Counts[] = $count;
        }
    }

    return view('dashboard', compact('questions', 'categories', 'categoryLabels', 'categoryCounts', 'kecamatanList', 'categoriesList', 'kecamatanLabels', 'kecamatanCounts', 'chatsThisMonth', 'chatsThisWeek', 'last14Labels', 'last14Counts'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Questions (Input Pertanyaan)
    Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');
    Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::get('/questions/check-new', [QuestionController::class, 'checkNew'])->name('questions.checkNew');
    Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');
    Route::get('/questions/{question}', [QuestionController::class, 'show'])->name('questions.show');
    Route::get('/questions/{question}/detail', [QuestionController::class, 'detail'])->name('questions.detail');
    Route::get('/questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
    Route::patch('/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
    Route::patch('/questions/{question}/mark-replied', [QuestionController::class, 'markReplied'])->name('questions.markReplied');
    Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');

    // Categories (Kategori Layanan)
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

    // API: kelurahan data for a kecamatan (returns labels + counts), optionally filtered by category_id
    Route::get('/kecamatan/{kecamatan}/kelurahan-data', function (Request $request, $kecamatan) {
        if (!\Illuminate\Support\Facades\Schema::hasTable('questions')) {
            return response()->json(['labels' => [], 'data' => []]);
        }

        $query = DB::table('questions')
            ->select('kelurahan', DB::raw('count(*) as count'))
            ->where('kecamatan', $kecamatan)
            ->whereNotNull('kelurahan')
            ->where('kelurahan', '<>', '');

        if ($request->query('category_id')) {
            $query->where('jenis_layanan_id', $request->query('category_id'));
        }

        $stats = $query->groupBy('kelurahan')
            ->orderByDesc('count')
            ->get();

        $labels = $stats->pluck('kelurahan');
        $data = $stats->pluck('count');

        return response()->json(['labels' => $labels, 'data' => $data]);
    })->name('kecamatan.kelurahan.data');

    // Dashboard activity endpoint: returns labels + counts between two dates
    Route::get('/dashboard/activity', function (Request $request) {
        if (!\Illuminate\Support\Facades\Schema::hasTable('questions')) {
            return response()->json(['labels' => [], 'data' => []]);
        }

        try {
            $from = $request->query('from') ? Carbon::parse($request->query('from'))->startOfDay() : Carbon::now()->subDays(13)->startOfDay();
            $to = $request->query('to') ? Carbon::parse($request->query('to'))->endOfDay() : Carbon::now()->endOfDay();
        } catch (\Exception $e) {
            return response()->json(['labels' => [], 'data' => []]);
        }

        if ($from->gt($to)) {
            // swap
            $tmp = $from; $from = $to; $to = $tmp;
        }

        $period = CarbonPeriod::create($from->copy()->startOfDay(), $to->copy()->startOfDay());

        $rows = DB::table('questions')
            ->select(DB::raw('DATE(created_at) as day'), DB::raw('count(*) as count'))
            ->whereBetween('created_at', [$from, $to])
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->pluck('count', 'day')
            ->toArray();

        $labels = [];
        $data = [];
        foreach ($period as $dt) {
            $key = $dt->format('Y-m-d');
            $labels[] = $dt->format('d M');
            $data[] = isset($rows[$key]) ? (int) $rows[$key] : 0;
        }

        return response()->json(['labels' => $labels, 'data' => $data]);
    })->name('dashboard.activity');
});

require __DIR__.'/auth.php';
