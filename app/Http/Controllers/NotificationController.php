<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suhu;
use App\Models\Ph;
use App\Models\Ppm;
use App\Models\Notification;
use App\Models\ParameterSuhu;

class NotificationController extends Controller
{
    public function checkNotifications()
    {
        // Cek suhu
        // $latestSuhu = Suhu::find(1);
        // if ($latestSuhu) {
        //     $latestParameterSuhu = $this->tampilparameterSuhu();
        //     if ($latestSuhu->suhu < $latestParameterSuhu->min_suhu || $latestSuhu->suhu > $latestParameterSuhu->max_suhu) {
        //         $this->createNotification('Suhu', 'Suhu diatas parameter. Segera tambahkan air dingin dan dinginkan instalasi');
        //     }
        // }
    
        // $notifications = Notification::latest()->get();
        $notifications = array(
            "id" => "1",
            "suhu" => "50",
            "max" => "true",
            
        );
        //return view('home',['notifications' => $notifications]);
        return response()->json($notifications);
    }

    private function createNotification($type, $message)
    {
        Notification::create([
            'type' => $type,
            'message' => $message,
        ]);
    }

    public function tampilparameterSuhu()
    {
    $latestParameterSuhu = ParameterSuhu::find(1);
    return $latestParameterSuhu;
    }




}
