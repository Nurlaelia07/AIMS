<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ppm extends Model
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
