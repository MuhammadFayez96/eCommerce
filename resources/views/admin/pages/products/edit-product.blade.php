@extends('admin.master')

@section('content-header')
    <section class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><h4>Products</h4></li>
                <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('products')}}">Products</a></li>
                <li class="breadcrumb-item"><a href="{{url('products/get-update/'.$product->id)}}">Edit Products</a>
                </li>
            </ol>
        </nav>
    </section>
@endsection

@section('content')

    <section class="content">
        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading" style="font-size: large">Products</div>

            <form action="{{ url('products/post-update/'.$product->id) }}" onsubmit="return false;" method="post"
                  class="update-form">

                {!! csrf_field() !!}

                <div class="panel-body">

                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="name" class="col-2 col-form-label ">Name</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="name" name="name_en"
                                       placeholder="iPhone" value="{{$product->product_translated->name}}">
                            </div>
                        </div>

                        <div class="form-group col-sm-4">
                            <label for="type" class="col-2 col-form-label">Type</label>
                            <div class="col-10">
                                <select class="form-control" name="type_en" id="type"
                                        onchange="return normalProduct();">
                                    <option value="{{$product->product_translated->type}}">
                                        Current: {{$product->product_translated->type}}</option>
                                    <option value="normal">Normal</option>
                                    <option value="option">Option</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-sm-4">
                            <label for="category" class="col-2 col-form-label">Category</label>
                            <div class="col-10">
                                <select class="form-control" name="category_id" id="category">
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">
                                            Current: {{$category->category_translated->category}}</option>
                                        <option value="{{$category->id}}">{{$category->category_translated->category}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="description" class="col-2 col-form-label ">Description</label>
                            <div class="col-10">
                                    <textarea class="form-control" rows="3" id="description" name="description_en"
                                              placeholder="any thing">{{$product->product_translated->description}}</textarea>
                            </div>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="notes" class="col-2 col-form-label">Notes</label>
                            <div class="col-10">
                                <div class="col-10">
                                    <textarea class="form-control " rows="5" id="notes" name="notes_en"
                                              placeholder="any thing">{{$product->product_translated->notes}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="normal-product" style="visibility: hidden;">
                        @if($product->product_translated->type == 'normal')
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="discount_type" class="col-2 col-form-label ">Discount Type</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" id="discount_type" name="discount_type"
                                               placeholder="normal" value="{{$Normal->discount_type}}">
                                    </div>
                                </div>

                                <div class="form-group col-sm-6">
                                    <label for="price" class="col-2 col-form-label ">Price</label>
                                    <div class="col-10">
                                        <input class="form-control " type="text" id="price" name="price"
                                               placeholder="10" value="{{$Normal->price}}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="serial" class="col-2 col-form-label ">Serial</label>
                                    <div class="col-10">
                                        <input class="form-control " type="text" id="serial" name="serial"
                                               placeholder="1234" value="{{$Normal->serial}}">
                                    </div>
                                </div>

                                <div class="form-group col-sm-6">
                                    <label for="modelNumber" class="col-2 col-form-label ">Model Number</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" id="modelNumber" name="modelNumber"
                                               placeholder="10" value="{{$Normal->model_number}}">
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="barcode" class="col-2 col-form-label ">Barcode</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" id="barcode" name="barcode"
                                               placeholder="1245" value="{{$Normal->barcode}}">
                                    </div>
                                </div>

                                <div class="form-group col-sm-6">
                                    <label for="discount" class="col-2 col-form-label ">Discount</label>
                                    <div class="col-10">
                                        <input class="form-control required" type="text" id="discount" name="discount"
                                               placeholder="10" value="{{$Normal->discount}}">
                                    </div>
                                </div>

                                <div class="form-group col-sm-6">
                                    <label for="stock" class="col-2 col-form-label ">Stock</label>
                                    <div class="col-10">
                                        <input class="form-control required" type="text" id="stock" name="stock"
                                               placeholder="10" value="{{$Normal->stock}}">
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div id="option-product" style="visibility: hidden;">
                        @if($product->product_translated->type == 'option')
                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <label for="option" class="col-2 col-form-label">Option Value</label>
                                    <div class="col-10">
                                        <select class="form-control" name="option_value_id" id="option_value_id">
                                            @foreach($options as $option)
                                                {{--<option value="{{$option->id}}">/ </option>--}}
                                                <optgroup label="{{$option->option_translated->option}}">
                                                    @foreach($optionValues as $value)
                                                        <option value="{{$option->id}}">{{$value->value}}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label for="price" class="col-2 col-form-label ">Price</label>
                                    <div class="col-10">
                                        <input class="form-control required" type="text" id="price" name="option_price"
                                               placeholder="10" value="{{$Option->price}}">
                                    </div>
                                </div>


                                <div class="form-group col-sm-4">
                                    <label for="serial" class="col-2 col-form-label ">Serial</label>
                                    <div class="col-10">
                                        <input class="form-control required" type="text" id="serial"
                                               name="option_serial"
                                               placeholder="1234" value="{{$Option->serial}}">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="model_number" class="col-2 col-form-label ">Model Number</label>
                                    <div class="col-10">
                                        <input class="form-control required" type="text" id="model_number"
                                               name="option_model_number"
                                               placeholder="10" value="{{$Option->model_number}}">
                                    </div>
                                </div>

                                <div class="form-group col-sm-6">
                                    <label for="barcode" class="col-2 col-form-label ">Barcode</label>
                                    <div class="col-10">
                                        <input class="form-control required" type="text" id="barcode"
                                               name="option_barcode"
                                               placeholder="1245" value="{{$Option->barcode}}">
                                    </div>
                                </div>

                            </div>


                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="discount" class="col-2 col-form-label ">Discount</label>
                                    <div class="col-10">
                                        <input class="form-control required" type="text" id="discount"
                                               name="option_discount"
                                               placeholder="10" value="{{$Option->discount}}">
                                    </div>
                                </div>

                                <div class="form-group col-sm-6">
                                    <label for="stock" class="col-2 col-form-label ">Stock</label>
                                    <div class="col-10">
                                        <input class="form-control required" type="text" id="stock" name="option_stock"
                                               placeholder="10" value="{{$Option->stock}}">
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn-update-submit btn btn-warning btn-md btn-flat">
                            Edit <span class="glyphicon glyphicon-save"> </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
