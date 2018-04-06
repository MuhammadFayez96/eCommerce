@extends('admin.master')

@section('content-header')
    <section class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><h4>Roles</h4></li>
                <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('roles')}}">Roles</a></li>
                <li class="breadcrumb-item"><a href="{{url('roles/get-update/'.$role->id)}}">Edit Roles</a></li>
            </ol>
        </nav>
    </section>
@endsection

@section('content')

    <section class="content">
        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading" style="font-size: large">Roles</div>

            <form action="{{ url('roles/post-update/'.$role->id) }}" onsubmit="return false;" method="post"
                  class="update-form">

                {!! csrf_field() !!}

                <div class="panel-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="role" class="col-2 col-form-label ">Role</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="role" name="role"
                                       placeholder="Egypt"  value="{{$role->role}}">
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="displayName" class="col-2 col-form-label ">Display Name</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="displayName" name="role_displayName_en"
                                       placeholder="Egypt"  value="{{$role_translated->displayName}}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="description" class="col-2 col-form-label ">Description</label>
                            <div class="col-10">
                                    <textarea class="form-control" rows="3" id="description" name="role_description_en"
                                              placeholder="any thing">{{$role_translated->description}}</textarea>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="notes" class="col-2 col-form-label ">Notes</label>
                            <div class="col-10">
                                    <textarea class="form-control " rows="5" id="notes" name="role_notes_en"
                                              placeholder="any thing">{{$role_translated->notes}}</textarea>
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
