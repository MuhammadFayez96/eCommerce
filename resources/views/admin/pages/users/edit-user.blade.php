@extends('admin.master')

@section('content-header')
    <section class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><h4>Edit Users</h4></li>
                <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('users')}}">Users</a></li>
                <li class="breadcrumb-item"><a href="{{url('users/get-update/'.$user->id)}}">Edit Users</a></li>
            </ol>
        </nav>
    </section>
@endsection

@section('content')

    <section class="content">
        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading" style="font-size:large">Users</div>

            <form action="{{ url('users/post-update/'.$user->id) }}" onsubmit="return false;" method="post"
                  class="update-form">

                {!! csrf_field() !!}
                <div class="panel-body">
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
                                       placeholder="EX: mahmoud" value="{{$user->name}}">
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="password" class="col-2 col-form-label">Password (one capital litter/ 8chars /one
                                Number)</label>
                            <div class="col-10">
                                <input class="form-control required" type="password" id="password" name="password"
                                >
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="email" class="col-2 col-form-label ">Email</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="email" name="email"
                                       placeholder="EX: m@m.com" value="{{$user->email}}">
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="address_1" class="col-2 col-form-label">Address-1</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="address_1" name="address_1"
                                       placeholder="Egypt" value="{{$user->address_1}}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="address_2" class="col-2 col-form-label ">Address-2</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="address_2" name="address_2"
                                       placeholder="Tanta" value="{{$user->address_2}}">
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="phone" class="col-2 col-form-label">Phone</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="phone" name="phone"
                                       value="{{$user->phone}}">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="mobile" class="col-2 col-form-label ">Mobile</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="mobile" name="mobile"
                                       placeholder="0402541179" value="{{$user->mobile}}">
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="gender" class="col-2 col-form-label">Gender</label>
                            <div class="col-10">
                                <select class="form-control" name="gender" id="gender">
                                    <option value="{{$user->gender}}">
                                        Current: {{$user->gender =='male' ? 'male': 'female'}}</option>
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
                                       placeholder="1618" value="{{$user->postal_code}}">
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="roles" class="col-2 col-form-label">Roles</label>
                            <div class="col-10">
                                <select class="form-control" name="roles" id="roles">
                                    <option value="{{$role->role}}">
                                        Current: {{$role->role}}</option>
                                    @foreach($roles as $role)
                                        <option value="">{{$role->role}}</option>
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
                                              placeholder="any thing">{{$user->notes}}</textarea>
                                </div>
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
