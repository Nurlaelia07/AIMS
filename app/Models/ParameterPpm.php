<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ParameterPpm extends Model
{
    use HasFactory;

    protected $table = 'parameter_ppm_air';
    protected $primaryKey = 'id_parameter_ppm_air';
    public $timestamps = false;

    protected $fillable = [
        'max_ppm_air',
        'min_ppm_air',
    ];
}