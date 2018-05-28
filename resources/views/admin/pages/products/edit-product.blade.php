@extends('admin.master')

@section('content-header')
    <section class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><h4>Products</h4></li>
                <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.products.getIndex')}}">Products</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.products.getUpdateProduct', ['id' => $product->id])}}">Edit Products</a>
                </li>
            </ol>
        </nav>
    </section>
@endsection

@section('content')

    <!-- start class content -->
    <section class="content">

        <!-- start div panel-primary  -->
        <div class="panel panel-primary">

            <!-- Default panel contents -->
            <div class="panel-heading" style="font-size: large">Products</div>

            <!-- start form submited -->
            <form action="{{ route('admin.products.updateProduct',[ 'id' => $product->id ]) }}" onsubmit="return false;" method="post"
                  class="update-form">

                {!! csrf_field() !!}

                <!-- start panel-body -->
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
                                placeholder="name in english" value="{{$product->en->name}}">
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <div class="col-10">
                                <input class="form-control required" type="text" id="name_ar" name="name_ar"
                                       placeholder="الاسم باللغة العربية" value="{{$product->ar->name}}">
                            </div>
                        </div>
                    </div>
                    <!-- end of name en & ar div row -->

                    <!-- start category and product type div row -->
                    <div class="row">
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

                        <div class="form-group col-sm-6">
                            <label for="type" class="col-2 col-form-label">Type</label>
                            <div class="col-10">
                                <select class="form-control" name="type_en" id="type">
                                    <option value="{{$product->en->type}}">{{$product->type}}</option>
                                    <option value="normal">normal</option>
                                    <option value="option">option</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- end of category and product type div row -->

                    <!-- start description en div row -->
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="description" class="col-2 col-form-label ">Description EN</label>
                        </div>

                        <div class="form-group col-sm-12">
                            <div class="col-10">
                                    <textarea class="form-control" rows="3" id="description_en" name="description_en"
                                              placeholder="description in english">{{$product->en->description}}</textarea>
                            </div>
                        </div>
                    </div>
                    <!-- end of description en div row -->

                    <!-- start description ar div row -->
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="description" class="col-2 col-form-label" style="float: right;">الوصف باللغة العربيه</label>
                        </div>

                        <div class="form-group col-sm-12">
                            <div class="col-10">
                                    <textarea class="form-control" rows="3" id="description_ar" name="description_ar"
                                              placeholder="الوصف باللغة العربية">{{$product->ar->description}}</textarea>
                            </div>
                        </div>
                    </div>
                    <!-- end of description ar div row -->

                    <!-- strart notes en div row -->
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="notes" class="col-2 col-form-label">Notes EN</label>
                        </div>

                        <div class="form-group col-sm-12">
                            <div class="col-10">
                                <textarea class="form-control " rows="5" id="notes_en" name="notes_en"
                                          placeholder="notes in english">{{$product->en->notes}}</textarea>
                            </div>
                        </div>
                    </div>
                    <!-- end of notes en div row -->

                    <!-- start notes ar div row -->
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="notes" class="col-2 col-form-label">الملاحظات باللغة العربيه</label>
                        </div>

                        <div class="form-group col-sm-12">
                            <div class="col-10">
                                <textarea class="form-control " rows="5" id="notes_ar" name="notes_ar"
                                          placeholder="الملاحظات باللغة العربيه">{{$product->ar->notes}}</textarea>
                            </div>
                        </div>
                    </div>
                    <!-- end of notes en div row -->

                    <!-- start footer div  -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning btn-md btn-flat">
                            Edit <span class="glyphicon glyphicon-save"> </span>
                        </button>
                    </div>
                    <!-- end footer div  -->

                </div>
                <!--end of panel div  -->

            </form>
            <!-- end of submited form -->

        </div>
        <!-- end of panel-primary div -->

    </section>
    <!-- end of section -->
@endsection
