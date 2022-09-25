<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function materials()
    {
        return $this->belongsToMany('App\Material')
            ->withPivot('required')
            ->withTimestamps();
    }

    public static  function getCost(Product $product){
        $materials = $product->materials()->withPivot('required')->get();
        $cost = 0;
        foreach ($materials as $material){
            $cost += ($material->price * $material->pivot->required);
        }

        return $cost;
    }

    public static  function getCostID($product){
        $product = Product::find($product);
        $materials = $product->materials()->withPivot('required')->get();
        $cost = 0;
        foreach ($materials as $material){
            $cost += ($material->price * $material->pivot->required);
        }

        return $cost;
    }
}
