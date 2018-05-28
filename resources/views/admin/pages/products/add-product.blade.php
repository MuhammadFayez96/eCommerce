@extends('admin.master')

@section('content-header')
    <section class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><h4>Products</h4></li>
                <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.products.getIndex')}}">Products</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.products.getCreateNewProduct')}}">Add Products</a></li>
            </ol>
        </nav>
    </section>
@endsection

@section('content')

    <!-- start section  -->
    <section class="content">

        <!-- start panel-primary div -->
        <div class="panel panel-primary">

            <!-- Default panel contents -->
            <div class="panel-heading" style="font-size: large">Products</div>

            <!-- start form submited -->
            <form action="{{ url('products/create') }}" onsubmit="return false;" method="post"
                  class="add-form">

                {!! csrf_field() !!}

                <!-- start class panel -->
                <div class="panel-body">

                    <!-- start name en & ar labels div row -->
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="name" class="col-2 col-form-label ">Product Name EN</label>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="name" class="col-2 col-form-label" style="float: right;">اسم المنتج باللغة العربيه</label>
                        </div>
                    </div>
                    <!-- end name en & ar div row -->

                    <!-- start name en & ar div row -->
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
                    <!-- end name en & ar div row  -->

                    <!-- start category and product type div row -->
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
                    <!-- end of category and product type div row -->

                    <!-- start descriptions en div row -->
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="description" class="col-2 col-form-label ">Description EN</label>
                        </div>

                        <div class="form-group col-sm-12">
                            <div class="col-10">
                                    <textarea class="form-control" rows="3" id="description_en" name="description_en"
                                              placeholder="description in english"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- end of descriptions en div row -->

                    <!-- start description ar div row  -->
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="description" class="col-2 col-form-label " style="float: right;">الوصف باللغة العربيه</label>
                        </div>

                        <div class="form-group col-sm-12">
                            <div class="col-10">
                                    <textarea class="form-control" rows="3" id="description_ar" name="description_ar"
                                              placeholder="الوصف باللغة العربية"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- end of description ar div row -->

                    <!-- start notes en div row -->
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="notes" class="col-2 col-form-label">Notes EN</label>
                        </div>

                        <div class="form-group col-sm-12">
                            <div class="col-10">
                                <textarea class="form-control " rows="5" id="notes_en" name="notes_en"
                                          placeholder="notes in english"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- end of notes en div row -->

                    <!-- start notes ar div row -->
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="notes" class="col-2 col-form-label" style="float: right;">الملاحظات باللغة العربيه</label>
                        </div>

                        <div class="form-group col-sm-12">
                            <div class="col-10">
                                <textarea class="form-control " rows="5" id="notes_ar" name="notes_ar"
                                          placeholder="الملاحظات باللغة العربيه"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- end of notes ar div row -->

                    <!-- start div footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn-submit btn btn-primary btn-md btn-flat">
                            Save <span class="glyphicon glyphicon-save"> </span>
                        </button>
                    </div>
                    <!-- end of div footer -->

                </div>
                <!-- end of class panel  -->

            </form>
            <!-- end of form -->

        </div>
        <!-- end of div panel primary  -->

    </section>
    <!-- end of section -->

@endsection
