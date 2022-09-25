<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Material;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = Cart::all();
        $products = Product::whereNotIn('id', $carts->pluck('product_id'))->get();
        return view('products.products', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.add');
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
            'name' => 'required',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;

        $product->save();

        return redirect()->route('products.index')->with('info-success', 'Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $materials = $product->materials()->withPivot('required')->get();
        $cost = $product->getCost($product);
        return view('products.required_materials', [
            'materials' => $materials,
            'product' => $product,
            'cost' => $cost
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product = Product::find($product->id);

        $this->validate($request, [
            'name' => 'required',
        ]);

        $product->name = $request->name;
        $product->description = $request->description;

        $product->save();

        return redirect()->route('products.index')->with('info-success', 'Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function searchMaterials(Request $request, $id){
        $product = Product::find($id);
        $materials = $product->materials()->withPivot('required')->get();
        $materials_all = Material::where('name', 'LIKE', "%$request->name%")
            ->whereNotIn('id', $materials->pluck('id'))->get();

        $cost = $product->getCost($product);
        return view('products.addMaterial', [
            'materials' => $materials,
            'materials_all' => $materials_all,
            'product' => $product,
            'cost' => $cost,
            'search_query' => $request->name
        ]);
    }

    public function addMaterialsPage($id){
        $product = Product::find($id);
        $materials = $product->materials()->withPivot('required')->get();
        $materials_all = Material::whereNotIn('id', $materials->pluck('id'))->get();

        $cost = $product->getCost($product);
        return view('products.addMaterial', [
            'materials' => $materials,
            'materials_all' => $materials_all,
            'product' => $product,
            'cost' => $cost,
            'search_query' => ''
        ]);
    }

    public function  addMaterials(Request $request, $id){
        $this->validate($request, [
            'material_id' => 'required|exists:materials,id',
            'required' => 'required|numeric',
        ]);

        $product = Product::find($id);
        $material = Material::find($request->material_id);
        foreach ($product->materials()->get() as $mat){
            if($material->id == $mat->id){
                return redirect()->back()->with('info-error', 'Material already present in list of required materials for this product.');
            }
        }
        $product->materials()->attach($material, ['required' => $request->required]);

        return redirect()->route('products.add_material', ['id' => $product->id])->with('info-success', 'Added');

    }

    public function removeMaterial(Request $request, $id){

        $product = Product::find($id);
        $material = Material::find($request->material_id);
        $product->materials()->detach($material);

        return redirect()->route('products.add_material', ['id' => $product->id])->with('info-success', 'Removed');

    }
}
