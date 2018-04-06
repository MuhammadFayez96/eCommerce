@extends('admin.master')

@section('content-header')
    <section class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><h4>Categories</h4></li>
                <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('categories')}}">Categories</a></li>
                <li class="breadcrumb-item"><a href="{{url('categories/get-create')}}">Add
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

            <form action="{{route('admin.categories.createNewCategory')}}" class="add-form"
                  enctype="multipart/form-data"
                  method="post"
                  onsubmit="return false;">
                {!! csrf_field() !!}
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="category" class="col-2 col-form-label ">Category</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="category" name="category_en"
                                       placeholder="EX: category">
                            </div>
                        </div>


                        <div class="form-group col-sm-6">
                            <label for="menus" class="col-2 col-form-label">Menus</label>
                            <div class="col-10">
                                <select class="form-control" name="menu_id" id="menus">
                                    <option value="">choose menu:</option>
                                    @foreach($menus as $menu)
                                        <option value="{{$menu->id}}">{{$menu->menu_translated->menu}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="description" class="col-2 col-form-label ">Description</label>

                            <div class="col-10">
                                    <textarea class="form-control" rows="3" id="description"
                                              name="category_description_en"
                                              placeholder="any thing"></textarea>
                            </div>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="notes" class="col-2 col-form-label">Notes</label>
                            <div class="col-10">
                                <div class="col-10">
                                    <textarea class="form-control required" rows="5" id="notes" name="category_notes_en"
                                              placeholder="any thing"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

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