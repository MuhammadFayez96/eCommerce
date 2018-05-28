@extends('admin.master')

@section('content-header')
    <section class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><h4>Categories</h4></li>
                <li class="breadcrumb-item"><a href="{{  route('admin.home')  }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{  route('admin.categories.getIndex')  }}">Categories</a></li>
                <li class="breadcrumb-item"><a href="{{  route('admin.categories.getCreateNewCategory')  }}">Add
                        Categories</a></li>
            </ol>
        </nav>
    </section>
@endsection

@section('content')

    <section class="content">
        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading" style="font-size: large">Categories</div>

            <form action="{{ route('admin.categories.createNewCategory') }}" class="add-form"
                  enctype="multipart/form-data"
                  method="post"
                  onsubmit="return false;">
                {!! csrf_field() !!}
                <div class="modal-body">

                    <!-- for menus -->
                    <div class="row">

                        <div class="col-md-6">

                            <label style="display: block; margin-bottom: 2.5%;">Choose Category Type</label>

                            <div class="radio-inline">
                                <label style="font-weight: 100;"><input type="radio" name="category_type" value="main" checked>main category</label>
                            </div>
                            <div class="radio-inline">
                                 <label style="font-weight: 100;"><input type="radio" name="category_type" value="sub">sub category</label>
                            </div>

                        </div>

                        <div class="form-group col-sm-6 menus-div">
                            <label for="menus" class="col-2 col-form-label">Menus</label>
                            <div class="col-10">
                                <select class="form-control" name="menu_id" id="menus">
                                    @foreach($menus as $menu)
                                        <option value="{{$menu->id}}">{{$menu->menu_translated->menu}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-sm-6 hidden categories-div">
                            <label for="main_category_id" class="col-2 col-form-label">Main Category</label>
                            <div class="col-10">
                                <select class="form-control" name="main_category_id" id="main_categories">
                                    @foreach($main_categories as $category)
                                        <option value="{{$category->id}}">{{$category->trans->category}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <!-- end of menus -->

                    <!-- for category -->
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="category" class="col-2 col-form-label ">Category</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <div class="col-10">
                                <input class="form-control required" type="text" id="category" name="category_en"
                                       placeholder="category in english">
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <div class="col-10">
                                <input class="form-control required" type="text" id="category" name="category_ar"
                                placeholder="القسم باللغة العربية">
                            </div>
                        </div>
                    </div>
                    <!-- end of category -->

                    <!-- for description -->
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="description" class="col-2 col-form-label ">Description</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <div class="col-10">
                                    <textarea class="form-control" rows="3" id="description"
                                              name="description_en"
                                              placeholder="description in english"></textarea>
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <div class="col-10">
                                    <textarea class="form-control" rows="3" id="description"
                                              name="description_ar"
                                              placeholder="الوصف باللغة العربية"></textarea>
                            </div>
                        </div>
                    </div>
                    <!--end of description  -->

                    <!-- for notes -->
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="notes" class="col-2 col-form-label">Notes</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <div class="col-10">
                                <div class="col-10">
                                    <textarea class="form-control" rows="5" id="notes" name="notes_en"
                                              placeholder="notes in english"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <div class="col-10">
                                <div class="col-10">
                                    <textarea class="form-control" rows="5" id="notes" name="notes_ar"
                                              placeholder="الملاحظات بالغة العربية"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end of notes  -->

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn-submit btn btn-primary btn-sm btn-flat">
                            Save <span class="glyphicon glyphicon-save"> </span>
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </section>
@endsection

@section('scripts')

    <script>

        /**
        * hande change event on main or sub radio
        */

        $("input[name='category_type']").on('change', function() {

            var type = $("input[name='category_type']:checked").val();

            if (type == 'sub') {

                $('.categories-div').removeClass('hidden');
                $('.menus-div').addClass('hidden');

            } else {
                $('.menus-div').removeClass('hidden');
                $('.categories-div').addClass('hidden');
            }

        });

    </script>

@endsection
