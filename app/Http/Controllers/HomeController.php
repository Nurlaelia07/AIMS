<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suhu;
use App\Models\Ph;


class HomeController extends Controller
{
    public function homeData()
    {
        $suhu = Suhu::orderBy('id_suhu', 'desc')->first();
        $ph = Ph::orderBy('id_ph', 'desc')->first();
        // $ppm = Ppm::find(1);
    
        return view('home', compact('suhu', 'ph'));
    }
}
