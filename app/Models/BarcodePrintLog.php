<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarcodePrintLog extends Model
{
    protected $fillable = [
        'product_id',
        'product_code',
        'product_name',
        'product_price',
        'copies_printed',
        'printed_at',
        'printed_by',
    ];

    protected $casts = [
        'product_price' => 'decimal:2',
        'printed_at' => 'datetime',
    ];
}
