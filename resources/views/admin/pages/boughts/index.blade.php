@extends('admin.master')

@section('content-header')
    <section class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><h4>boughts</h4></li>
                <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('boughts')}}">Boughts</a></li>
            </ol>
        </nav>
    </section>
@endsection

@section('content')
    <section class="content">

        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading" style="font-size: large">Boughts</div>
            <form action="{{ url('admin/boughts/') }}" onsubmit="return false;">

                {{ csrf_field() }}

                <div class="panel-body">
                    <a href="{{url('boughts/get-create')}}" class="btn btn-primary btn-sm">
                        <li class="fa fa-plus"> Add bought</li>
                    </a>
                </div>

                <div class="table-responsive">
                    <!-- Table -->
                    <table class="table">
                        <thead>
                        <tr style="color: black; font-size: medium;">
                            <th class="text-center"></th>
                            <th class="text-center"></th>
                            <th class="text-center"></th>
                            <th class="text-center"></th>
                            <th class="text-center">Operations</th>
                        </tr>
                        </thead>
                        <tbody class="table-hover">
                        {{--@foreach($boughts as $bought)--}}
                            <tr>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center">
                                    <a href="{{url('boughts/get-update')}}"
                                       class="btn btn-warning btn-sm">
                                        <li class="fa fa-pencil"> Edit</li>
                                    </a>

                                    <a class="btn btn-danger btn-sm" title="Delete" data-toggle="modal"
                                       href="#delete"
                                       data-id=""
                                       data-token="{{csrf_token()}}">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        {{--@endforeach--}}
                        </tbody>

                    </table>
                </div>
            </form>
        </div>
    </section>

@endsection

@section('modals')
    @include('admin.pages.boughts.modals.delete-bought')
@endsection

