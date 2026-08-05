<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Question;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        $categories = Category::withCount('questions')->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return response('Form Kategori Layanan (placeholder)');
    }

    /**
     * Display the questions for a specific category.
     */
    public function show(\Illuminate\Http\Request $request, Category $category)
    {
        $selectedKecamatan = $request->query('kecamatan');
        $selectedKelurahan = $request->query('kelurahan');

        // Start from category questions; we'll order by smallest selisih (time diff) first,
        // then by tanggal (Y-m-d) ascending and jam_masuk ascending.
        $query = $category->questions();

        if (!empty($selectedKecamatan)) {
            $query->where('kecamatan', $selectedKecamatan);
        }

        if (!empty($selectedKelurahan)) {
            $query->where('kelurahan', $selectedKelurahan);
        }

            // Order: tanggal ascending (terlama paling atas), lalu jam_masuk ascending.
            // Pastikan jam_masuk NULL berada di bawah. Selisih tidak digunakan untuk ordering.
            $query->orderBy('tanggal', 'asc')
                ->orderByRaw("CASE WHEN jam_masuk IS NULL THEN 1 ELSE 0 END ASC")
                ->orderBy('jam_masuk', 'asc');

          $questions = $query->paginate(15)->appends($request->only('kecamatan', 'kelurahan'));

        // distinct lists for selects (scoped to this category)
        $kecamatans = $category->questions()->select('kecamatan')->distinct()->whereNotNull('kecamatan')->pluck('kecamatan');

        if (!empty($selectedKecamatan)) {
            $kelurahans = $category->questions()->where('kecamatan', $selectedKecamatan)->select('kelurahan')->distinct()->whereNotNull('kelurahan')->pluck('kelurahan');
        } else {
            $kelurahans = $category->questions()->select('kelurahan')->distinct()->whereNotNull('kelurahan')->pluck('kelurahan');
        }

        return view('categories.show', compact('category', 'questions', 'kecamatans', 'kelurahans', 'selectedKecamatan', 'selectedKelurahan'));
    }
}
