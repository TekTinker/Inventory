<?php

namespace App\Http\Controllers;

use App\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materials = Material::all();
        return view('materials.materials', ['materials' => $materials]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('materials.add');
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
            'name' => 'required',
            'unit' => 'required|in:unit,m,kg,war',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric'
        ]);

        $material = new Material();

        $material->name = $request->name;
        $material->description = $request->description;
        $material->price = $request->price;
        $material->quantity = $request->quantity;
        $material->unit = $request->unit;

        $material->save();

        return redirect()->route('materials.index')->with('info-success', 'Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Material $material
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        return view('materials.edit', ['material' => $material]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Material $material
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Material $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Material $material)
    {
        $material = Material::find($material->id);

        $this->validate($request, [
            'name' => 'required',
            'unit' => 'required|in:unit,m,kg,war',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric'
        ]);

        $material->name = $request->name;
        $material->description = $request->description;
        $material->price = $request->price;
        $material->quantity = $request->quantity;
        $material->unit = $request->unit;

        $material->save();

        return redirect()->route('materials.index')->with('info-success', 'Updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Material $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {
        //
    }
}
