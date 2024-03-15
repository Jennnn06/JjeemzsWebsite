<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentsFolder extends Model
{
    use HasFactory;
    
    protected $table = 'equipmentsfolder';

    protected $fillable = [
        'equipmentsname',
        'equipmentsimage'
    ];
}
