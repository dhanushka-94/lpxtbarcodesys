<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'products';
    protected $table = 'sma_products';
    public $timestamps = false;
    
    protected $fillable = [
        'code',
        'name',
        'price',
        'cost',
        'quantity',
        'barcode_symbology',
        'category_id',
        'brand',
        'image',
        'second_name',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cost' => 'decimal:2',
        'quantity' => 'decimal:2',
    ];
}
