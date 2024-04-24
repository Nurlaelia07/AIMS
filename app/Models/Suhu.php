<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suhu extends Model
{
    use HasFactory;
    
    protected $table = 'suhu';
    protected $primaryKey = 'id_suhu';
    public $timestamps = false;

    protected $fillable = [
        'suhu',
        'tanggal',
        'waktu',
    ];
}


