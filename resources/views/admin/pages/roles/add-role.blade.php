@extends('admin.master')


@section('content-header')
    <section class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><h4>Roles</h4></li>
                <li class="breadcrumb-item"><a href="{{  route('admin.home')  }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{  route('admin.roles.getIndex')  }}">Roles</a></li>
                <li class="breadcrumb-item"><a href="{{  route('admin.roles.getCreateNewRole')  }}">Add Roles</a></li>
            </ol>
        </nav>
    </section>
@endsection

@section('content')

    <section class="content">
        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading" style="font-size: large">Roles</div>

            <form action="{{route('admin.roles.createNewRole')}}" class="add-form" enctype="multipart/form-data"
                  method="post"
                  onsubmit="return false;">
                {!! csrf_field() !!}
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="role" class="col-2 col-form-label ">Role Name</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="role" name="role"
                                       placeholder="EX: Admin">
                            </div>
                        </div>

                    </div>
                    <div class="row">

                        <div class="form-group col-sm-6">
                            <label for="role" class="col-2 col-form-label ">Display Name</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="role" name="role_displayName_en"
                                       placeholder="EX: Administrator">
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="displayName" class="col-2 col-form-label" style="float: right;">اسم العرض</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="displayName"
                                       name="role_displayName_ar"
                                       style="direction: rtl"
                                       placeholder="مثلا: مدير النظام">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="description" class="col-2 col-form-label ">Description</label>
                            <div class="col-10">
                                    <textarea class="form-control " rows="3" id="description" name="role_description_en"
                                              placeholder="any thing"></textarea>
                            </div>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="description" class="col-2 col-form-label" style="float: right;">الوصف باللغة العربيه</label>
                            <div class="col-10">
                                    <textarea class="form-control" rows="3" name="role_description_ar"
                                    style="direction: rtl;"></textarea>
                            </div>
                        </div>
                    </diV>
                    
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="notes" class="col-2 col-form-label">Notes</label>
                            <div class="col-10">
                                    <textarea class="form-control required" rows="5" id="notes" name="role_notes_en"
                                              placeholder="any thing"></textarea>
                            </div>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="notes" class="col-2 col-form-label" style="float: right;"> الملحوظات باللغة العربيه</label>
                            <div class="col-10">
                                <div class="col-10">
                                    <textarea class="form-control required" rows="5" name="role_notes_ar"
                                    style="direction: rtl;"></textarea>
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
