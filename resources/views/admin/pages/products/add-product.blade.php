@extends('admin.master')

@section('content-header')
    <section class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><h4>Products</h4></li>
                <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('products')}}">Products</a></li>
                <li class="breadcrumb-item"><a href="{{url('products/get-create')}}">Add Products</a></li>
            </ol>
        </nav>
    </section>
@endsection

@section('content')

    <section class="content">
        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading" style="font-size: large">Products</div>

            <form action="{{ url('products/create') }}" onsubmit="return false;" method="post"
                  class="add-form">

                {!! csrf_field() !!}

                <div class="panel-body">

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="name" class="col-2 col-form-label ">Name</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <div class="col-10">
                                <input class="form-control required" type="text" id="name_en" name="name_en"
                                placeholder="name in english">
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <div class="col-10">
                                <input class="form-control required" type="text" id="name_ar" name="name_ar"
                                       placeholder="الاسم باللغة العربية">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="description" class="col-2 col-form-label ">Description</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <div class="col-10">
                                    <textarea class="form-control" rows="3" id="description_en" name="description_en"
                                              placeholder="description in english"></textarea>
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <div class="col-10">
                                    <textarea class="form-control" rows="3" id="description_ar" name="description_ar"
                                              placeholder="الوصف باللغة العربية"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="notes" class="col-2 col-form-label">Notes</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <div class="col-10">
                                <textarea class="form-control " rows="5" id="notes_en" name="notes_en"
                                          placeholder="notes in english"></textarea>
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <div class="col-10">
                                <textarea class="form-control " rows="5" id="notes_ar" name="notes_ar"
                                          placeholder="المزكره بالفه العربية"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- category type -->
                        <div class="form-group col-sm-6">
                            <label for="category" class="col-2 col-form-label">Category</label>
                            <div class="col-10">
                                <select class="form-control" name="category_id" id="category">
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->category_translated->category}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!--  product type -->
                        <div class="form-group col-sm-6">
                            <label for="type" class="col-2 col-form-label">Type</label>
                            <div class="col-10">
                                <select class="form-control" name="type_en" id="type" onchange="return Product();">
                                    <option value="normal">Normal</option>
                                    <option value="option">Option</option>
                                </select>
                            </div>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="submit" class="btn-submit btn btn-primary btn-md btn-flat">
                        Save <span class="glyphicon glyphicon-save"> </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
