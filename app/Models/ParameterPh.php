<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ParameterPh extends Model
{
    use HasFactory;

    protected $table = 'parameter_ph_air';
    protected $primaryKey = 'id_parameter_ph_air';
    public $timestamps = false;

    protected $fillable = [
        'max_ph_air',
        'min_ph_air',
    ];
}