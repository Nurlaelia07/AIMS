<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ParameterSuhu extends Model
{
    use HasFactory;

    protected $table = 'parameter_suhu';
    protected $primaryKey = 'id_paramater_suhu';
    public $timestamps = false;

    protected $fillable = [
        'max_suhu',
        'min_suhu',
    ];
}