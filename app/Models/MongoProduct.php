<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
class MongoProduct extends Model
{
    use HasFactory;

    protected $collection = 'products';

    protected $fillable = [
        'product_data'
    ];
}
