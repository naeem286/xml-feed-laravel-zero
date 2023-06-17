<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_data'
    ];

    protected $casts = [
        'product_data' => 'array'
    ];
}

