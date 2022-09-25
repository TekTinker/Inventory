<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = DB::table('carts')
            ->leftJoin('products', 'carts.product_id', '=', 'products.id')
            ->select('*', 'carts.id as id')
            ->get();

        $grand_total = 0;

        foreach ($carts as $cart){
            $cart->total_cost = Product::getCostID($cart->product_id);
            $grand_total += ($cart->total_cost * $cart->quantity);
        }


        return view('cart.cart', ['carts' => $carts, 'grand_total' => $grand_total]);
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|exists:products,id',
        ]);

        $cart = new Cart();

        $cart->user_id = Auth::id();
        $cart->product_id = $request->product_id;
        $cart->quantity = 1;
        $cart->save();

        return redirect()->back()->with('info-success', 'Added to Cart');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        $this->validate($request, [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric',
        ]);

        $cart->quantity = $request->quantity;
        $cart->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();
        return redirect()->back()->with('info-success', 'Removed');
    }
}
