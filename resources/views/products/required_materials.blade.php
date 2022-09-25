@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="container">
            <div class="row py-4">
                <div class="col-10">
                    <p class="h3">Required Materials for {{ $product->name }}</p>
                </div>
                <div class="col-2">
                    <a href="{{ route('products.add_material', ['id' => $product->id]) }}" class="btn btn-primary">Add\Edit</a>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price/Unit</th>
                            <th scope="col">Required Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($materials as $material)
                            <tr>
                                <th scope="row">{{ $material->id }}</th>
                                <td>{{ $material->name }}</td>
                                <td>Rs {{ $material->price }} / {{ $material->unit }}</td>
                                <td>{{ $material->pivot->required }} {{ $material->unit }}</td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row justify-content-end">
                <p class="h5">Total Cost Rs {{ $cost }}</p>
            </div>
        </div>
    </div>
@endsection
