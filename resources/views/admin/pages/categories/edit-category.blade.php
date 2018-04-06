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

            <form action="{{ url('categories/post-update/'.$category->id) }}" onsubmit="return false;" method="post"
                  class="update-form">

                {!! csrf_field() !!}

                <div class="panel-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="category" class="col-2 col-form-label ">Category</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="category" name="category_en"
                                       placeholder="Egypt"  value="{{$category_translated->category}}">
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="menus" class="col-2 col-form-label">Menus</label>
                            <div class="col-10">
                                <select class="form-control" name="menu_id" id="menus">
                                    @foreach($menus as $menu)
                                        <option value="{{$menu->menu_translated->menu}}">
                                            Current: {{$menu->menu_translated->menu}}</option>
                                        <option value="{{$menu->id}}">{{$menu->menu_translated->menu}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="description" class="col-2 col-form-label ">description</label>
                            <div class="col-10">
                                    <textarea class="form-control required" rows="3" id="description"
                                              name="category_description_en"
                                              placeholder="any thing">{{$category_translated->description}}</textarea>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="notes" class="col-2 col-form-label">Notes</label>
                            <div class="col-10">
                                    <textarea class="form-control required" rows="5" id="notes" name="category_notes_en"
                                              placeholder="any thing">{{$category_translated->notes}}</textarea>
                            </div>
                        </div>
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
