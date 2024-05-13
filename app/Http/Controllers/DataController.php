<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suhu;

class DataController extends Controller
{
    public function store(Request $request)
    {
        $data = new Suhu();
        $data->tanggal = $request->input('tanggal');
        $data->waktu = $request->input('waktu');
        $data->suhu = $request->input('suhu');
        $data->save();

        return response()->json(['message' => 'Data tersimpan.']);
    }
}
