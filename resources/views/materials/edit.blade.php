@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="container">
            <div class="row row justify-content-center">
                <p class="h3">Edit Material</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-10">
                    <form action="{{ route('materials.update', ['material' => $material->id]) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-3 col-form-label">Name</label>
                            <div class="col-9">
                                <input name="name" type="text"
                                       class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name"
                                       placeholder="Name"
                                       value="{{Request::old('name') ?: $material->name }}">
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-3 col-form-label">Description</label>
                            <div class="col-9">
                                <input name="description" type="text" class="form-control" id="description"
                                       placeholder="Description"
                                       value="{{Request::old('description') ?: $material->description }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="exampleFormControlSelect1" class="col-3 col-form-label">Select Color</label>
                        @if(Request::old('color') != '')
                            <!-- {{ $color = Request::old('color') }} -->
                        @else
                            <!-- {{ $color = $material->color }} -->
                            @endif
                            <div class="col-9">
                                <select class="form-control {{ $errors->has('color') ? ' is-invalid' : '' }}"
                                        id="exampleFormControlSelect1" name="color">
                                    @foreach(config('constants.colors') as $c)
                                        <option value={{ $c }} {{$color == $c ? 'selected': ''}}>{{ $c }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('color'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('color') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group row">
                            <label for="price" class="col-3 col-form-label">Price</label>
                            <div class="col-9">
                                <input name="price" type="text"
                                       class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" id="price"
                                       placeholder="Price"
                                       value="{{Request::old('price') ?: $material->price }}">
                                @if ($errors->has('price'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="quantity" class="col-3 col-form-label">Quantity</label>
                            <div class="col-9">
                                <input name="quantity" type="text"
                                       class="form-control{{ $errors->has('quantity') ? ' is-invalid' : '' }}"
                                       id="quantity" placeholder="Quantity"
                                       value="{{Request::old('quantity') ?: $material->quantity }}">
                                @if ($errors->has('quantity'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('quantity') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="exampleFormControlSelect1" class="col-3">Select Unit</label>
                            @if(Request::old('unit') != '')
                                <!-- {{ $unit = Request::old('unit') }} -->
                            @else
                                <!--    {{ $unit = $material->unit }} -->
                            @endif
                            <div class="col-9">
                                <select class="form-control {{ $errors->has('unit') ? ' is-invalid' : '' }}"
                                        id="exampleFormControlSelect1" name="unit">
                                    @foreach(config('constants.units') as $u)
                                        <option value={{ $u }} {{$unit == $u ? 'selected': ''}}>{{ $u }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('unit'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('unit') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-9">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
