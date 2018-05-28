@extends('admin.master')

@section('content-header')
    <section class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><h4>Menus</h4></li>
                <li class="breadcrumb-item"><a href="{{  route('admin.home')  }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{  route('admin.menus.getIndex')  }}">Menus</a></li>
                <li class="breadcrumb-item"><a href="{{  route('admin.menus.getUpdateMenu', [ 'id' => $menu->id])  }}">Edit Menus</a></li>
            </ol>
        </nav>
    </section>
@endsection

@section('content')

    <section class="content">
        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading" style="font-size: large">Menus</div>

            <form action="{{route('admin.menus.updateMenu')}}" class="add-form" enctype="multipart/form-data"
                  method="post"
                  onsubmit="return false;">
                {!! csrf_field() !!}

                <input type="hidden" name="id" value="{{$menu->id}}">

                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="menu" class="col-2 col-form-label ">Menu Name EN</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" name="menu_en"
                                       placeholder="EX: Electronics"
                                       value="{{$menu->en->menu}}">
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="menu" class="col-2 col-form-label" style="float: right;">اسم القائمة باللغة العربيه</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" name="menu_ar"
                                   style="direction: rtl;"
                                   placeholder="مثلا: الالكترونيات"
                                   value="{{$menu->ar ? $menu->ar->menu : ''}}">
                            </div>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="description" class="col-2 col-form-label ">Description EN</label>
                            <div class="col-10">
                                    <textarea class="form-control" rows="3" id="description" name="menu_description_en">{{$menu->en->description}}</textarea>
                            </div>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="description" class="col-2 col-form-label" style="float: right;">الوصف باللغة العربيه</label>
                            <div class="col-10">
                                    <textarea class="form-control" rows="3" name="menu_description_ar"
                                    style="direction: rtl;">{{$menu->ar ? $menu->ar->description : ''}}</textarea>
                            </div>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="notes" class="col-2 col-form-label">Notes EN</label>
                            <div class="col-10">
                                <div class="col-10">
                                    <textarea class="form-control required" rows="5" name="menu_notes_en">{{$menu->en ? $menu->en->notes : ''}}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="notes" class="col-2 col-form-label" style="float: right;"> الملحوظات باللغة العربيه</label>
                            <div class="col-10">
                                <div class="col-10">
                                    <textarea class="form-control required" rows="5" name="menu_notes_ar"
                                    style="direction: rtl;">{{$menu->ar ? $menu->ar->notes : ''}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn-submit btn btn-primary btn-sm btn-flat">
                            Save <span class="glyphicon glyphicon-save"> </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
