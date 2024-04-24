<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ph extends Model
{
    use HasFactory;
    
    protected $table = 'ph_air';
    protected $primaryKey = 'id_ph';
    public $timestamps = false;

    protected $fillable = [
        'ph_air',
        'tanggal',
        'waktu',
    ];
}


