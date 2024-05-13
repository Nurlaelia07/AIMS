<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ppm;
use App\Models\ParameterPpm;
use App\Models\Control;
use Illuminate\Support\Carbon;

class PpmController extends Controller
{
    public function index(Request $request)
    {
        try {
            $filter = $request->input('filter');
            $riwayatPpm = Ppm::orderBy('tanggal', 'desc')->orderBy('waktu', 'desc');
    
            switch ($filter) {
                case 'jam':
                    $riwayatPpm->select(
                        'tanggal',
                        Ppm::raw('HOUR(waktu) as jam'),
                        Ppm::raw('AVG(ppm_air) as ppm')
                    )
                    ->groupBy('tanggal', Ppm::raw('HOUR(waktu)'))
                    ->orderBy('tanggal', 'desc')
                    ->orderBy(Ppm::raw('HOUR(waktu)'), 'desc');
                    break;
    
                case 'hari':
                    $riwayatPpm->select(
                        Ppm::raw('DATE_FORMAT(tanggal, "%Y-%m-%d") as tanggal'),
                        Ppm::raw('AVG(ppm_air as ppm')
                    )
                    ->groupBy(Ppm::raw('DATE_FORMAT(tanggal, "%Y-%m-%d")'))
                    ->orderBy(Ppm::raw('DATE_FORMAT(tanggal, "%Y-%m-%d")'), 'desc');
                    break;
    
                    case 'bulan':
                        $riwayatPpm->select(
                            Ppm::raw('YEAR(tanggal) as tahun'),
                            Ppm::raw("MONTHNAME(tanggal) as bulan"),
                            Ppm::raw('AVG(ppm_air) as ppm')
                        )
                        ->groupBy(Ppm::raw('YEAR(tanggal)'), Ppm::raw('MONTHNAME(tanggal)'))
                        ->orderBy(Ppm::raw('YEAR(tanggal)'), 'desc')
                        ->orderBy(Ppm::raw('MONTH(tanggal)'), 'desc');
                        break;
                    
                    
    
                default:
                    break;
            }
    
            $riwayatPpm = $riwayatPpm->paginate(10);
    
            return view('ppm.riwayat', ['riwayatPpm' => $riwayatPpm, 'filter' => $filter]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    
    
    
    
    
    public function latestppm()
    {
        $latestPpm = Ppm::orderBy('id_ppm', 'desc')->first();
        return view('ppm.ppm',  ['latestPpm'=> $latestPpm]);
    }

    // public function homeData()
    // {
    //     $Ppm = Ppm::orderBy('id_ppm', 'desc')->first();
    //     $ppm = Ppm::orderBy('id_ppm', 'desc')->first();
    //     // $ppm = Ppm::find(1);
    
    //     return view('home', compact('Ppm', 'ppm'));
    // }

    // public function bacappm()
    // {
    //     $ppmData = Ppm::select("*")->get();
    //     return view('Ppm.Ppm', ['nilaisensor'=> $ppmData]);
    // }

    public function updateparameterppm(Request $request)
    {
      try {
        $parameter = Parameterppm::find(1);
        $maxppm = $request->input('max_ppm_air');
        $minppm = $request->input('min_ppm_air');
        $parameter->max_ppm_air = $maxppm;
        $parameter->min_ppm_air = $minppm;
        $parameter->save();
        return redirect()->back()->with('success', 'Parameter Ppm berhasil diperbarui.');
    } catch (\Illuminate\Database\QueryException $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui parameter Ppm: ' . $e->getMessage());
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui parameter Ppm.');
    }
    }

    // public function tampilparameterppm()
    // {
    //     $latestParameterppm = Parameterppm::find(1);
    //     return view('Ppm.Ppm', ['latestParameterppm' =>  $latestParameterppm]);
    // }



    


}