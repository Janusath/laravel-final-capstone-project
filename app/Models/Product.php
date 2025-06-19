<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'sku',
        'product_name',
        'product_image',
        'category_id',
        'brand_id',
        'cost_price',
        'selling_price',
    ];

}
