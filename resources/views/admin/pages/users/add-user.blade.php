@extends('admin.master')

@section('content-header')
    <section class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><h4>Add Users</h4></li>
                <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('users')}}">Users</a></li>
                <li class="breadcrumb-item"><a href="{{url('users/get-create')}}">Add Users</a></li>
            </ol>
        </nav>
    </section>
@endsection

@section('content')

    <section class="content">
        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading" style="font-size:large">Users</div>
            <form action="{{route('admin.users.createNewUser')}}" class="add-form" enctype="multipart/form-data"
                  method="post"
                  onsubmit="return false;">
                {!! csrf_field() !!}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-offset-5 col-md-2">
                            <div class="box box-primary">
                                <img style="cursor:pointer;"
                                     class="profile-user-img file-btn img-responsive img-circle"
                                     src="{{url('storage/uploads/images/avatars/admin-avatar-default.png')}}"
                                     alt="User profile picture">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="name" class="col-2 col-form-label ">Name</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="name" name="name"
                                       placeholder="EX: mahmoud">
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="password" class="col-2 col-form-label">Password (one capital litter/ 8chars /one
                                Number)</label>
                            <div class="col-10">
                                <input class="form-control required" type="password" id="password" name="password" placeholder="password">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="email" class="col-2 col-form-label ">Email</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="email" name="email"
                                       placeholder="EX: m@m.com">
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="address_1" class="col-2 col-form-label">Address-1</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="address_1" name="address_1"
                                       placeholder="Egypt">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="address_2" class="col-2 col-form-label ">Address-2</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="address_2" name="address_2"
                                       placeholder="Tanta">
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="phone" class="col-2 col-form-label">Phone</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="phone" name="phone"
                                       placeholder="0402541179">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="mobile" class="col-2 col-form-label ">Mobile</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="mobile" name="mobile"
                                       placeholder="01227678387">
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="gender" class="col-2 col-form-label">Gender</label>
                            <div class="col-10">
                                <select class="form-control" name="gender" id="gender">
                                    <option value="">choose gender:</option>
                                    <option value="male">male</option>
                                    <option value="female">female</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="postal_code" class="col-2 col-form-label ">Postal_Code</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="postal_code" name="postal_code"
                                       placeholder="1618">
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="roles" class="col-2 col-form-label">Roles</label>
                            <div class="col-10">
                                <select class="form-control" name="role_id" id="roles">
                                    <option value="">choose role:</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}">{{$role->role}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="notes" class="col-2 col-form-label">Notes</label>
                            <div class="col-10">
                                <div class="col-10">
                                    <textarea class="form-control required" rows="5" id="notes" name="notes"
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
