<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderedMaterial extends Model
{
    protected $fillable = [
        'order_id', 'material_id', 'name', 'description', 'color', 'unit', 'price', 'quantity'
    ];
}
