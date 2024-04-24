<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpmAir extends Model
{
    use HasFactory;

    protected $table = 'ppm_air';
    protected $primaryKey = 'id_ppm';
    public $timestamps = false;

    protected $fillable = [
        'ppm_air',
        'tanggal',
        'waktu',
    ];
}
