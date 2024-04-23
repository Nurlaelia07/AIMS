<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Models\Suhu;
use App\Models\Ph;
use App\Models\ParameterSuhu;
use App\Models\Control;
use Illuminate\Support\Carbon;


class SuhuController extends Controller
{
    public function index(Request $request)
    {
        try {
            $filter = $request->input('filter');
            $riwayatSuhu = Suhu::orderBy('tanggal', 'desc')->orderBy('waktu', 'desc');
    
            switch ($filter) {
                case 'jam':
                    $riwayatSuhu->select(
                        'tanggal',
                        Suhu::raw('HOUR(waktu) as jam'),
                        Suhu::raw('AVG(suhu) as suhu')
                    )
                    ->groupBy('tanggal', Suhu::raw('HOUR(waktu)'))
                    ->orderBy('tanggal', 'desc')
                    ->orderBy(Suhu::raw('HOUR(waktu)'), 'desc');
                    break;
    
                case 'hari':
                    $riwayatSuhu->select(
                        Suhu::raw('DATE_FORMAT(tanggal, "%Y-%m-%d") as tanggal'),
                        Suhu::raw('DAYNAME(tanggal) as hari'),
                        Suhu::raw('AVG(suhu) as suhu')
                    )
                    ->groupBy(Suhu::raw('DATE_FORMAT(tanggal, "%Y-%m-%d")'), Suhu::raw('hari')) 
                    ->orderBy(Suhu::raw('tanggal'), 'desc'); 

                $riwayatSuhu->orderByRaw("FIELD(hari, " . implode(',', array_map(function($day) {
                    return "'" . trans('day.' . strtolower($day)) . "'";
                }, ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'])) . ")");
                break;
                    
                
                
                

                case 'bulan':
                    $riwayatSuhu->select(
                        Suhu::raw('YEAR(tanggal) as tahun'),
                        Suhu::raw("MONTHNAME(tanggal) as bulan"),
                        Suhu::raw('AVG(suhu) as suhu')
                    )
                    ->groupBy(Suhu::raw('YEAR(tanggal)'), Suhu::raw('MONTHNAME(tanggal)'))
                    ->orderBy(Suhu::raw('YEAR(tanggal)'), 'desc')
                    ->orderBy(Suhu::raw('MONTH(tanggal)'), 'desc');
                    break;
                    
                    
    
                default:
                    break;
            }
    
            $riwayatSuhu = $riwayatSuhu->paginate(10);
    
            return view('suhu.riwayat', ['riwayatSuhu' => $riwayatSuhu, 'filter' => $filter]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    
    
    
    
    
    public function latestSuhu()
    {
        $latestSuhu = Suhu::orderBy('id_suhu', 'desc')->first();
        return view('suhu.suhu',  ['latestSuhu'=> $latestSuhu]);
    }

    // public function homeData()
    // {
    //     $suhu = Suhu::orderBy('id_suhu', 'desc')->first();
    //     $ph = Ph::orderBy('id_ph', 'desc')->first();
    //     // $ppm = Ppm::find(1);
    
    //     return view('home', compact('suhu', 'ph'));
    // }

    // public function bacasuhu()
    // {
    //     $suhuData = Suhu::select("*")->get();
    //     return view('suhu.suhu', ['nilaisensor'=> $suhuData]);
    // }

    public function updateparametersuhu(Request $request)
    {
        try {
            $request->validate([
                'max_suhu' => 'nullable|numeric',
                'min_suhu' => 'nullable|numeric',
            ]);

            if (!$request->filled('max_suhu') && !$request->filled('min_suhu')) {
                return redirect()->back()->with('error', 'Minimal satu bidang harus diisi.');
            }

            $parameter = ParameterSuhu::find(1);

            if ($request->filled('max_suhu')) {
                $parameter->max_suhu = $request->max_suhu;
            }

            if ($request->filled('min_suhu')) {
                $parameter->min_suhu = $request->min_suhu;
            }

            $parameter->save();
            return redirect()->back()->with('success', 'Parameter suhu berhasil diperbarui.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui parameter suhu: ' . $e->getMessage());
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui parameter suhu: ' . $e->getMessage());
        }
    }
    
    
    
    
    

    // public function tampilparameterSuhu()
    // {
    //     $latestParameterSuhu = ParameterSuhu::find(1);
    //     return view('suhu.suhu', ['latestParameterSuhu' =>  $latestParameterSuhu]);
    // }



    


}