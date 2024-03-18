<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipments extends Model
{
    use HasFactory;

    //Table name
    protected $table = 'equipments';

    protected $fillable = [
        'ITEM_IMAGE',
        'ITEM_NAME',
        'BRAND',
        'COLOR',
        'QUANTITY',
        'STATUS',
        'AVAILABLE',
        'IN_OUT',
        'REASON',
        'NOTE',
        'FOLDER',
    ];
}
