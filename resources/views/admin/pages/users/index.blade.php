@extends('admin.master')

@section('content-header')
    <section class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><h4>Users</h4></li>
                <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('users')}}">Users</a></li>
            </ol>
        </nav>
    </section>
@endsection

@section('content')
    <section class="content">

        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading" style="font-size: large">Users</div>

            <form action="{{ url('admin/users/') }}" onsubmit="return false;">

                {{ csrf_field() }}

                <div class="panel-body">
                    <a href="{{url('users/get-create')}}" class="btn btn-primary btn-md">
                        <li class="fa fa-plus"> Add User</li>
                    </a>
                </div>


                <div class="table-responsive">
                    <!-- Table -->
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>address-1</th>
                            {{--<th>address-2</th>--}}
                            <th>mobile</th>
                            {{--<th>phone</th>--}}
                            <th>gender</th>
                            <th>postal-code</th>
                            <th>notes</th>
                            <th class="text-center">operations</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->address_1}}</td>
                                {{--<td>{{$user->address_2}}</td>--}}
                                <td>{{$user->mobile}}</td>
                                {{--<td>{{$user->phone}}</td>--}}
                                <td>{{$user->gender}}</td>
                                <td>{{$user->postal_code}}</td>
                                <td>{{$user->notes}}</td>
                                <td class="text-center">
                                    <a href="{{url('users/get-update/'.$user->id)}}" class="btn btn-warning btn-sm">
                                        <li class="fa fa-pencil"> Edit</li>
                                    </a>

                                    <input type="hidden" name="_method" value="delete"/>

                                    <a class="btn btn-danger btn-sm" title="Delete" data-toggle="modal"
                                       href="#delete"
                                       data-id="{{$user->id}}"
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
    @include('admin.pages.users.modals.delete-user')
@endsection

