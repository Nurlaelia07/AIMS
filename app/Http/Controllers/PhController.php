<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Models\Ph;
use App\Models\ParameterPh;
use App\Models\Control;
use Illuminate\Support\Carbon;

class PhController extends Controller
{
    public function index(Request $request)
    {
        try {
            $filter = $request->input('filter');
            $riwayatPh = Ph::orderBy('tanggal', 'desc')->orderBy('waktu', 'desc');
    
            switch ($filter) {
                case 'jam':
                    $riwayatPh->select(
                        'tanggal',
                        Ph::raw('HOUR(waktu) as jam'),
                        Ph::raw('AVG(ph_air) as ph_air')
                    )
                    ->groupBy('tanggal', Ph::raw('HOUR(waktu)'))
                    ->orderBy('tanggal', 'desc')
                    ->orderBy(Ph::raw('HOUR(waktu)'), 'desc');
                    break;
    
                    case 'hari':
                        $riwayatPh->select(
                            Ph::raw('DATE_FORMAT(tanggal, "%Y-%m-%d") as tanggal'),
                            Ph::raw('DAYNAME(tanggal) as hari'),
                            Ph::raw('AVG(ph_air) as ph_air')
                        )
                        ->groupBy(Ph::raw('DATE_FORMAT(tanggal, "%Y-%m-%d")'), Ph::raw('hari')) 
                        ->orderBy(Ph::raw('tanggal'), 'desc'); 
    
                    $riwayatPh->orderByRaw("FIELD(hari, " . implode(',', array_map(function($day) {
                        return "'" . trans('day.' . strtolower($day)) . "'";
                    }, ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'])) . ")");
                    break;
    
                    case 'bulan':
                        $riwayatPh->select(
                            Ph::raw('YEAR(tanggal) as tahun'),
                            Ph::raw("MONTHNAME(tanggal) as bulan"),
                            Ph::raw('AVG(ph_air) as ph_air')
                        )
                        ->groupBy(Ph::raw('YEAR(tanggal)'), Ph::raw('MONTHNAME(tanggal)'))
                        ->orderBy(Ph::raw('YEAR(tanggal)'), 'desc')
                        ->orderBy(Ph::raw('MONTH(tanggal)'), 'desc');
                        break;
                    
                    
    
                default:
                    break;
            }
    
            $riwayatPh = $riwayatPh->paginate(10);
    
            return view('ph.riwayat', ['riwayatPh' => $riwayatPh, 'filter' => $filter]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    
    
    
    
    
    public function latestPh()
    {
        $latestPh = Ph::orderBy('id_ph', 'desc')->first();
        return view('ph.ph',  ['latestPh'=> $latestPh]);
    }

    // public function homeData()
    // {
    //     $Ph = Ph::orderBy('id_Ph', 'desc')->first();
    //     $ph = Ph::orderBy('id_ph', 'desc')->first();
    //     // $ppm = Ppm::find(1);
    
    //     return view('home', compact('Ph', 'ph'));
    // }

    // public function bacaPh()
    // {
    //     $PhData = Ph::select("*")->get();
    //     return view('Ph.Ph', ['nilaisensor'=> $PhData]);
    // }

    public function updateparameterph(Request $request)
    {

    try {
        $request->validate([
            'max_ph_air' => 'nullable|numeric',
            'min_ph_air' => 'nullable|numeric',
        ]);

        if (!$request->filled('max_ph_air') && !$request->filled('min_ph_air')) {
            return redirect()->back()->with('error', 'Minimal satu bidang harus diisi.');
        }

        $parameter = ParameterPh::find(1);

        if ($request->filled('max_ph_air')) {
            $parameter->max_ph_air = $request->max_ph_air;
        }

        if ($request->filled('min_ph_air')) {
            $parameter->min_ph_air = $request->min_ph_air;
        }

        $parameter->save();
        return redirect()->back()->with('success', 'Parameter ph berhasil diperbarui.');
    } catch (\Illuminate\Database\QueryException $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui parameter ph: ' . $e->getMessage());
    } catch (Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui parameter ph: ' . $e->getMessage());
    }

    }

    // public function tampilparameterPh()
    // {
    //     $latestParameterPh = ParameterPh::find(1);
    //     return view('Ph.Ph', ['latestParameterPh' =>  $latestParameterPh]);
    // }



    


}