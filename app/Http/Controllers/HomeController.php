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
        $suhu = Suhu::orderBy('id_suhu', 'desc')->first();
        $ph = Ph::orderBy('id_ph', 'desc')->first();
        $ppm = Ppm::orderBy('id_ppm', 'desc')->first();
    
        return view('home', compact('suhu', 'ph', 'ppm'));
    }
}
