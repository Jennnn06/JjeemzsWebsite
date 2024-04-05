<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogHistory extends Model
{
    use HasFactory;

    protected $table = 'log_history';
    
    protected $fillable = [
        'equipment_id',
        'ITEM',
        'BRAND',
        'QUANTITY',
        'LOCATION',
        'DATE_BORROWED',
        'BORROWER',
        'DATE_RETURNED',
        'RETURNEE',
        'BORROWER_SIGNATURE',
        'RETURNEE_SIGNATURE'
    ];
}
