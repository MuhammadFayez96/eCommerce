@extends('admin.master')

@section('content-header')
    <section class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><h4>Options</h4></li>
                <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('options')}}">Options</a></li>
            </ol>
        </nav>
    </section>
@endsection

@section('content')
    <section class="content">

        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading" style="font-size: large">Options</div>
            <form action="{{ url('admin/options/') }}" onsubmit="return false;">

                {{ csrf_field() }}

                <div class="panel-body">
                    <a href="{{url('options/get-create')}}" class="btn btn-primary btn-md">
                        <li class="fa fa-plus"> Add Option</li>
                    </a>
                </div>

                <div class="table-responsive">
                    <!-- Table -->
                    <table class="table">
                        <thead>
                        <tr style="color: black; font-size: medium;">
                            <th class="text-center">option</th>
                            <th class="text-center">Value</th>
                            <th class="text-center">operations</th>
                        </tr>
                        </thead>
                        <tbody class="table-hover">
                        @foreach($options as $option)
                            <tr>
                                <td class="text-center">{{$option->option_translated->option}}</td>
                                <td class="text-center">{{$option->option_value_translated->value}}</td>
                                <td class="text-center">
                                    <a href="{{url('options/get-update/'.$option->id)}}" class="btn btn-warning btn-sm">
                                        <li class="fa fa-pencil"> Edit</li>
                                    </a>

                                    <input type="hidden" name="_method" value="delete"/>

                                    <a class="btn btn-danger btn-sm" title="Delete" data-toggle="modal"
                                       href="#delete"
                                       data-id="{{$option->id}}"
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
    @include('admin.pages.options.modals.delete-option')
@endsection

