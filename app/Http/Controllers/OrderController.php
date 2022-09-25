<?php

namespace App\Http\Controllers;

use App\Material;
use App\Order;
use App\OrderedMaterial;
use App\OrderedProduct;
use App\OrderItem;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function listRequired(){
        $materials = DB::table('ordered_materials')
            ->select('*', DB::raw('SUM(quantity) as required'))
            ->groupBy('material_id')
            ->get();
        return view('required_materials.materials', ['materials' => $materials]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'delivery_date' => 'required|date',
        ]);

        $carts = DB::table('carts')
            ->leftJoin('products', 'carts.product_id', '=', 'products.id')
            ->select('*', 'carts.id as id')
            ->get();

        $order = Order::create([
            'order_date' => today(),
            'delivery_date' => $request->delivery_date,
            'status' => 'Order Placed',
            'remark' => $request->remark,
            'department' => $request->department,
        ]);

        $materials = Material::pluck( 'quantity', 'id');

        foreach ($materials as $key => $value){
            $materials[$key] = 0;
        }

        foreach ($carts as $cart){

            $required_materials = Product::find($cart->product_id)->materials()->withPivot('required')->get();

            OrderedProduct::create([
                'order_id' => $order->id,
                'product_id' => $cart->product_id,
                'name' => $cart->name,
                'description' => $cart->description,
                'color' => $cart->color,
                'type' => $cart->type,
                'quantity' => $cart->quantity
            ]);


            foreach ($required_materials as $rm){
                $materials[$rm->id] += ($rm->pivot->required * $cart->quantity);
            }

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cart->product_id,
                'quantity' => $cart->quantity,
            ]);
        }

        foreach ($materials as $key => $value){
            if($materials[$key]!=0){
                $m = Material::find($key);
                OrderedMaterial::create([
                    'order_id' => $order->id,
                    'material_id' => $m->id,
                    'name' => $m->name,
                    'description' => $m->description,
                    'color' => $m->color,
                    'unit' => $m->unit,
                    'price' => $m->price,
                    'quantity' => $materials[$key]
                ]);
            }
        }

        \auth()->user()->carts()->delete();

        return redirect()->back()->with('info-success', 'Order Placed');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
