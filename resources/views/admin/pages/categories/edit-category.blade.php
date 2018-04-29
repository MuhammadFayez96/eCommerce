@extends('admin.master')

@section('content-header')
    <section class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><h4>Categories</h4></li>
                <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('categories')}}">Categories</a></li>
                <li class="breadcrumb-item"><a href="{{url('categories/get-update/'.$category->id)}}">Edit Categories</a></li>
            </ol>
        </nav>
    </section>
@endsection

@section('content')

    <section class="content">
        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading" style="font-size: large">Categories</div>

            <form action="{{ route('admin.categories.updateCategory',[ 'id' => $category->id ]) }}" onsubmit="return false;" method="post"
                  class="update-form">

                {!! csrf_field() !!}

                <div class="panel-body">

                    <!-- for menus -->
                    <div class="row">
                        <div class="col-md-6">

                            <label style="display: block; margin-bottom: 2.5%;">Choose Category Type</label>

                            <div class="radio-inline">
                                <label style="font-weight: 100;">
                                    <input type="radio" name="category_type" value="main"
                                    {{$category->isMain() ? 'checked' : ''}}>
                                    main category
                                </label>
                            </div>
                            <div class="radio-inline">
                                 <label style="font-weight: 100;">
                                     <input type="radio" name="category_type" value="sub"
                                     {{$category->isMain() ? '' : 'checked'}}>
                                     sub category
                                 </label>
                            </div>

                        </div>

                        <div class="form-group col-sm-6 menus-div {{$category->isMain() ? '' : 'hidden'}}">
                            <label for="menus" class="col-2 col-form-label">Menus</label>
                            <div class="col-10">
                                <select class="form-control" name="menu_id" id="menus">
                                    @foreach($menus as $menu)
                                        <option
                                         {{$category->menu_id == $menu->id ? 'selected' : ''}}
                                         value="{{$menu->id}}">{{$menu->menu_translated->menu}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-sm-6 categories-div {{$category->isMain() ? 'hidden' : ''}}">
                            <label for="main_category_id" class="col-2 col-form-label">Main Category</label>
                            <div class="col-10">
                                <select class="form-control" name="main_category_id" id="main_categories">
                                    @foreach($main_categories as $main_category)
                                        <option
                                        {{$category->parent_id == $main_category->id ? 'selected' : ''}}
                                        value="{{$main_category->id}}">{{$main_category->trans->category}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--  end of menus -->

                    <!-- for category -->
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="category" class="col-2 col-form-label ">Category</label>
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group col-sm-6">
                            <div class="col-10">
                                <input class="form-control" type="text" id="category" name="category_en"
                                       placeholder="category in english"  value="{{$category->en->category}}">
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <div class="col-10">
                                <input class="form-control" type="text" id="category" name="category_ar"
                                       placeholder="القسم باللغة العربية"  value="{{$category->ar->category}}">
                            </div>
                        </div>
                    </div>
                    <!-- end of category -->

                    <!--  for description -->
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="description" class="col-2 col-form-label ">description</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <div class="col-10">
                                    <textarea class="form-control" rows="3" id="description"
                                              name="description_en"
                                              placeholder="description in english">{{$category->en->description}}</textarea>
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <div class="col-10">
                                    <textarea class="form-control" rows="3" id="description"
                                              name="description_ar"
                                              placeholder="الوصف باللغة العربية">{{$category->ar->description}}</textarea>
                            </div>
                        </div>
                    </div>
                    <!-- end of description -->

                    <!-- for notes -->
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="notes" class="col-2 col-form-label">Notes</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <div class="col-10">
                                    <textarea class="form-control" rows="5" id="notes" name="notes_en"
                                              placeholder="notes in english">{{$category->en->notes}}</textarea>
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <div class="col-10">
                                    <textarea class="form-control" rows="5" id="notes" name="notes_ar"
                                              placeholder="الملاحظات باللغة العربية">{{$category->ar->notes}}</textarea>
                            </div>
                        </div>
                    </div>
                    <!-- end of notes -->

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning btn-md btn-flat">
                            Edit <span class="glyphicon glyphicon-save"> </span>
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
