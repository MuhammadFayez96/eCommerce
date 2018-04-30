@extends('admin.master')

@section('content-header')
    <section class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><h4>Roles</h4></li>
                <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('roles')}}">Roles</a></li>
            </ol>
        </nav>
    </section>
@endsection

@section('content')
    <section class="content">

        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading" style="font-size: large">Roles</div>

            <form action="{{ url('admin/roles/') }}" onsubmit="return false;">
                {{ csrf_field() }}
                <div class="panel-body">
                    <a href="{{url('roles/get-create')}}" class="btn btn-primary btn-md">
                        <li class="fa fa-plus"> Add Role</li>
                    </a>
                </div>

                <div class="table-responsive">
                    <!-- Table -->
                    <table class="table">
                        <thead>
                        <tr style="color: black; font-size: medium;">
                            <th class="text-center">role</th>
                            <th class="text-center">display name EN</th>
                            <th class="text-center">display name AR</th>
                            <th class="text-center">notes</th>
                        </tr>
                        </thead>
                        <tbody class="table-hover">
                        @foreach($roles as $role)
                            <tr>
                                <td class="text-center">{{$role->role}}</td>
                                <td class="text-center">{{$role->display_name_en}}</td>
                                <td class="text-center">{{$role->display_name_ar}}</td>
                                <td class="text-center">
                                    <a href="{{url('roles/get-update/'.$role->id)}}" class="btn btn-warning btn-sm">
                                        <li class="fa fa-pencil"> Edit</li>
                                    </a>

                                    <input type="hidden" name="_method" value="delete"/>

                                    <a class="btn btn-danger btn-sm" title="Delete" data-toggle="modal"
                                       href="#delete"
                                       data-id="{{$role->id}}"
                                       data-token="{{csrf_token()}}">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </section>

@endsection

@section('modals')
    @include('admin.pages.roles.modals.delete-role')
@endsection
