<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
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
                        Ppm::raw('AVG(ppm_air) as ppm_air')
                    )
                    ->groupBy('tanggal', Ppm::raw('HOUR(waktu)'))
                    ->orderBy('tanggal', 'desc')
                    ->orderBy(Ppm::raw('HOUR(waktu)'), 'desc');
                    break;
    
                    case 'hari':
                        $riwayatPpm->select(
                            Ppm::raw('DATE_FORMAT(tanggal, "%Y-%m-%d") as tanggal'),
                            Ppm::raw('DAYNAME(tanggal) as hari'),
                            Ppm::raw('AVG(ppm_air) as ppm_air')
                        )
                        ->groupBy(Ppm::raw('DATE_FORMAT(tanggal, "%Y-%m-%d")'), Ppm::raw('hari')) 
                        ->orderBy(Ppm::raw('tanggal'), 'desc'); 
    
                    $riwayatPpm->orderByRaw("FIELD(hari, " . implode(',', array_map(function($day) {
                        return "'" . trans('day.' . strtolower($day)) . "'";
                    }, ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'])) . ")");
                    break;
    
                    case 'bulan':
                        $riwayatPpm->select(
                            Ppm::raw('YEAR(tanggal) as tahun'),
                            Ppm::raw("MONTHNAME(tanggal) as bulan"),
                            Ppm::raw('AVG(ppm_air) as ppm_air')
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
    
    
    
    
    
    public function latestPpm()
    {
        $latestPpm = Ppm::orderBy('id_ppm', 'desc')->first();
        return view('ppm.ppm',  ['latestPpm'=> $latestPpm]);
    }

    public function parameter()
    {
        $parameters = ParameterPpm::first();

        if ($parameters) {
            return response()->json($parameters);
        } else {
            return response()->json(['message' => 'Parameter not found'], 404);
        }
    }

    // public function homeData()
    // {
    //     $Ppm = Ppm::orderBy('id_Ppm', 'desc')->first();
    //     $ppm = Ppm::orderBy('id_ppm', 'desc')->first();
    //     // $ppm = Ppm::find(1);
    
    //     return view('home', compact('Ppm', 'ppm'));
    // }

    // public function bacaPpm()
    // {
    //     $PpmData = Ppm::select("*")->get();
    //     return view('Ppm.Ppm', ['nilaisensor'=> $PpmData]);
    // }

    public function updateparameterppm(Request $request)
    {
        try {
            $request->validate([
                'max_ppm_air' => 'nullable|numeric',
                'min_ppm_air' => 'nullable|numeric',
            ]);
    
            if (!$request->filled('max_ppm_air') && !$request->filled('min_ppm_air')) {
                return redirect()->back()->with('error', 'Minimal satu bidang harus diisi.');
            }
    
            $parameterPpm = ParameterPpm::find(1); // Ganti variabel $parameter menjadi $parameterPpm
    
            if ($request->filled('max_ppm_air')) {
                $parameterPpm->max_ppm_air = $request->max_ppm_air;
            }
    
            if ($request->filled('min_ppm_air')) {
                $parameterPpm->min_ppm_air = $request->min_ppm_air;
            }
    
            $parameterPpm->save(); // Ganti $parameter menjadi $parameterPpm
            return redirect()->back()->with('success', 'Parameter ppm berhasil diperbarui.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui parameter ppm: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui parameter ppm: ' . $e->getMessage());
        }
    }
    
    

    // public function tampilparameterPpm()
    // {
    //     $latestParameterPpm = ParameterPpm::find(1);
    //     return view('Ppm.Ppm', ['latestParameterPpm' =>  $latestParameterPpm]);
    // }



    


}