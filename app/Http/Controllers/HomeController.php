<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suhu;
use App\Models\Ph;
use App\Models\Ppm;

class HomeController extends Controller
{
    public function homeData()
    {
        $suhu = Suhu::orderByDesc('id_suhu')->first();
        $ph = Ph::orderByDesc('id_ph')->first();
        $ppm = Ppm::orderByDesc('id_ppm')->first();

        return view('home', [
            'suhu' => $suhu,
            'ph' => $ph,
            'ppm' => $ppm
        ]);
    }
}
