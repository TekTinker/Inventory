<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderedProduct extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'name', 'description', 'color', 'type', 'quantity'
    ];
}
