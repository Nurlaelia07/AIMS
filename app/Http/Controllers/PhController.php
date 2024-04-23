<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
                        Ph::raw('AVG(ph_air) as ph')
                    )
                    ->groupBy('tanggal', Ph::raw('HOUR(waktu)'))
                    ->orderBy('tanggal', 'desc')
                    ->orderBy(Ph::raw('HOUR(waktu)'), 'desc');
                    break;
    
                case 'hari':
                    $riwayatPh->select(
                        Ph::raw('DATE_FORMAT(tanggal, "%Y-%m-%d") as tanggal'),
                        Ph::raw('AVG(ph_air as ph')
                    )
                    ->groupBy(Ph::raw('DATE_FORMAT(tanggal, "%Y-%m-%d")'))
                    ->orderBy(Ph::raw('DATE_FORMAT(tanggal, "%Y-%m-%d")'), 'desc');
                    break;
    
                    case 'bulan':
                        $riwayatPh->select(
                            Ph::raw('YEAR(tanggal) as tahun'),
                            Ph::raw("MONTHNAME(tanggal) as bulan"),
                            Ph::raw('AVG(ph_air) as ph')
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
        $parameter = ParameterPh::find(1);
        $maxPh = $request->input('max_ph_air');
        $minPh = $request->input('min_ph_air');
        $parameter->max_ph_air = $maxPh;
        $parameter->min_ph_air = $minPh;
        $parameter->save();
        return redirect()->back()->with('success', 'Parameter Ph berhasil diperbarui.');
    } catch (\Illuminate\Database\QueryException $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui parameter Ph: ' . $e->getMessage());
    } catch (Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui parameter Ph.');
    }
    }

    // public function tampilparameterPh()
    // {
    //     $latestParameterPh = ParameterPh::find(1);
    //     return view('Ph.Ph', ['latestParameterPh' =>  $latestParameterPh]);
    // }



    


}