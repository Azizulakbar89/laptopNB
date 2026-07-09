<?php

namespace App\Http\Controllers;

use App\Models\DataLatih;
use App\Models\DataUji;
use App\Models\HasilPrediksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $naiveBayesService;

    public function __construct(\App\Services\NaiveBayesService $naiveBayesService)
    {
        $this->naiveBayesService = $naiveBayesService;
    }

    public function index()
    {
        $totalDataLatih = DataLatih::count();
        $totalDataUji = DataUji::count();
        $totalPrediksi = HasilPrediksi::where('id_prediksi', '!=', 'METRIK')->count();

        $latestPrediksi = HasilPrediksi::where('id_prediksi', '!=', 'METRIK')
            ->with('dataUji')
            ->latest()
            ->take(5)
            ->get();

        $statistikKelas = DataLatih::select('kelas', \DB::raw('count(*) as total'))
            ->groupBy('kelas')
            ->get();

        $metrik = $this->naiveBayesService->getMetrikEvaluasi();

        return view('dashboard', compact(
            'totalDataLatih',
            'totalDataUji',
            'totalPrediksi',
            'latestPrediksi',
            'statistikKelas',
            'metrik'
        ));
    }
}
