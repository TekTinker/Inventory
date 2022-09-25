@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="container">
            <div class="row row justify-content-center">
                <p class="h3">Edit Product</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <form action="{{ route('products.update', ['product' => $product->id]) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input name="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" placeholder="Name"
                                       value="{{Request::old('name') ?: $product->name }}">
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>

                        <div class="form-group row">
                            <label for="exampleFormControlSelect1" class="col-sm-3 col-form-label">Select Type</label>
                            @if(Request::old('type') != '')
                                <!-- {{ $type = Request::old('type') }} -->
                            @else
                                <!-- {{ $type = $product->type }} -->
                            @endif
                            <div class="col-sm-9">
                                <select class="form-control {{ $errors->has('type') ? ' is-invalid' : '' }}"
                                        id="exampleFormControlSelect1" name="type">
                                    @foreach(config('constants.types') as $t)
                                        <option value={{ $t }} {{$type == $t ? 'selected': ''}}>{{ $t }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('type'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group row">
                            <label for="exampleFormControlSelect1" class="col-sm-3 col-form-label">Select Color</label>
                            @if(Request::old('color') != '')
                                <!-- {{ $color = Request::old('color') }} -->
                            @else
                                <!-- {{ $color = $product->color }} -->
                            @endif
                            <div class="col-sm-9">
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
                            <label for="description" class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9">
                                <input name="description" type="text" class="form-control" id="description"
                                       placeholder="Description"
                                       value="{{Request::old('description') ?: $product->description }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
