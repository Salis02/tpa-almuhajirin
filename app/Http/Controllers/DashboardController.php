<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\TpaClass;
use App\Models\Ustadz;
use Illuminate\Http\Request;

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

        return view('dashboard', compact('stats', 'recentSantri', 'classes'));
    }
}