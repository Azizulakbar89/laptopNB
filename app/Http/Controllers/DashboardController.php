<?php

namespace App\Http\Controllers;

use App\Models\DataLatih;
use App\Models\DataUji;
use App\Models\HasilPrediksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDataLatih = DataLatih::count();
        $totalDataUji = DataUji::count();
        $totalPrediksi = HasilPrediksi::count();

        $latestPrediksi = HasilPrediksi::with('dataUji')
            ->latest()
            ->take(5)
            ->get();

        $statistikKelas = DataLatih::select('kelas', \DB::raw('count(*) as total'))
            ->groupBy('kelas')
            ->get();

        return view('dashboard', compact(
            'totalDataLatih',
            'totalDataUji',
            'totalPrediksi',
            'latestPrediksi',
            'statistikKelas'
        ));
    }
}
