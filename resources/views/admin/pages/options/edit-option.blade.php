@extends('admin.master')

@section('content-header')
    <section class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><h4>Options</h4></li>
                <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('options')}}">Options</a></li>
                <li class="breadcrumb-item"><a href="{{url('options/get-update/'.$option->id)}}">Edit Options</a></li>
            </ol>
        </nav>
    </section>
@endsection

@section('content')

    <section class="content">
        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading" style="font-size: large">Options</div>

            <form action="{{ url('options/post-update/'.$option->id) }}" onsubmit="return false;" method="post"
                  class="update-form">

                {!! csrf_field() !!}

                <div class="panel-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="option" class="col-2 col-form-label ">Option</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="option" name="option_name_en"
                                       placeholder="Egypt" value="{{$option->option_translated->option}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($optionValues as $value)
                            <div class="form-group col-sm-6">
                                <label for="value" class="col-2 col-form-label ">Value</label>
                                <div class="col-10">
                                    <input class="form-control required" type="text" id="value" name="option_value_en[]"
                                           placeholder="Egypt" value="{{$value->value}}">
                                </div>
                            </div>
                        @endforeach
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
