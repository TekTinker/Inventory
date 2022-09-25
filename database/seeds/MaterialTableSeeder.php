<?php

use Illuminate\Database\Seeder;

class MaterialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = config('constants.units');
        $colors = config('constants.colors');
        $types = config('constants.types');


        for($i = 0; $i<50; $i++){
            $material = new \App\Material();
            $material->name = str_random(20);
            $material->color = array_random($colors);
            $material->description = str_random(20);
            $material->price = rand(10, 10000);
            $material->unit = array_random($units);
            $material->quantity = rand(0.0, 1000);
            $material->save();
        }


        $material = new \App\Material();
        $material->name = "Polyester Knitted Fabric (Bubble Air)";
        $material->color = array_random($colors);
        $material->description = str_random(20);
        $material->price = rand(10, 10000);
        $material->unit = array_random($units);
        $material->quantity = rand(0.0, 1000);
        $material->save();

        $material = new \App\Material();
        $material->name = "Polyester Lining Fabric 1000D Black";
        $material->color = array_random($colors);
        $material->description = str_random(20);
        $material->price = rand(10, 10000);
        $material->unit = array_random($units);
        $material->quantity = rand(0.0, 1000);
        $material->save();

        $material = new \App\Material();
        $material->name = "PVC Coated Fabric 1000 D Light Parrot Green";
        $material->color = array_random($colors);
        $material->description = str_random(20);
        $material->price = rand(10, 10000);
        $material->unit = array_random($units);
        $material->quantity = rand(0.0, 1000);
        $material->save();

        $material = new \App\Material();
        $material->name = "Net Sponge Jali 12 Kgs Black";
        $material->color = array_random($colors);
        $material->description = str_random(20);
        $material->price = rand(10, 10000);
        $material->unit = array_random($units);
        $material->quantity = rand(0.0, 1000);
        $material->save();

        $material = new \App\Material();
        $material->name = "Chain 8 No Regular Neon Green";
        $material->color = array_random($colors);
        $material->description = str_random(20);
        $material->price = rand(10, 10000);
        $material->unit = array_random($units);
        $material->quantity = rand(0.0, 1000);
        $material->save();


        $p = new \App\Product();
        $p->name = "WIP Chameleon 01 Bag Maroon";
        $p->color = array_random($colors);
        $p->description = str_random(20);
        $p->type = array_random($types);
        $p->save();

        $p = new \App\Product();
        $p->name = "WIP Gold 003 Bag Airport Blue";
        $p->color = array_random($colors);
        $p->description = str_random(20);
        $p->type = array_random($types);
        $p->save();

        $p = new \App\Product();
        $p->name = "WIP Ultra 001 MTT Bag Navy Blue";
        $p->color = array_random($colors);
        $p->description = str_random(20);
        $p->type = array_random($types);
        $p->save();

        $p = new \App\Product();
        $p->name = "WIP Regal 021 Bag Dark Grey";
        $p->color = array_random($colors);
        $p->description = str_random(20);
        $p->type = array_random($types);
        $p->save();

    }
}
