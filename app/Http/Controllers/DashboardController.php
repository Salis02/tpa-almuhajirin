<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\TpaClass;
use App\Models\Ustadz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_santri' => Santri::count(),
            'active_santri' => Santri::where('status', 'active')->count(),
            'male_santri' => Santri::where('gender', 'L')->where('status', 'active')->count(),
            'female_santri' => Santri::where('gender', 'P')->where('status', 'active')->count(),
            'total_ustadz' => Ustadz::where('status', 'active')->count(),
            'total_classes' => TpaClass::where('is_active', true)->count(),
        ];

        $recentSantri = Santri::with('tpaClass')
            ->where('status', 'active')
            ->latest()
            ->limit(6)
            ->get();

        $classes = TpaClass::with(['activeSantris'])
            ->where('is_active', true)
            ->get();

              // 🔹 Mingguan (52 minggu terakhir)
        $growthWeekly = Santri::select(
                DB::raw("DATE_FORMAT(created_at, '%x-%v') as period"), // tahun-minggu
                DB::raw("COUNT(*) as total")
            )
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        // 🔹 Bulanan (12 bulan terakhir)
        $growthMonthly = Santri::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as period"),
                DB::raw("COUNT(*) as total")
            )
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        // 🔹 Tahunan
        $growthYearly = Santri::select(
                DB::raw("YEAR(created_at) as period"),
                DB::raw("COUNT(*) as total")
            )
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        return view('dashboard', compact(
            'stats',
            'recentSantri',
            'classes',
            'growthWeekly',
            'growthMonthly',
            'growthYearly'
        ));
    }
}