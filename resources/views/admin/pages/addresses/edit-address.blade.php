@extends('admin.master')

@section('content-header')
    <section class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><h4>Addresses</h4></li>
                <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('addresses')}}">Addresses</a></li>
                <li class="breadcrumb-item"><a href="{{url('addresses/get-update/'.$country->id)}}">Edit Addresses</a>
                </li>
            </ol>
        </nav>
    </section>
@endsection

@section('content')

    <section class="content">
        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading" style="font-size: large">Address</div>

            <form action="{{ url('addresses/post-update/'.$country->id) }}" onsubmit="return false;" method="post"
                  class="update-form">

                {!! csrf_field() !!}

                <div class="panel-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="country" class="col-2 col-form-label ">Country</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="country" name="country_name_en"
                                       placeholder="Egypt" value="{{$country_details->country}}">
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="country_code" class="col-2 col-form-label ">Country_code</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="country_code" name="country_code"
                                       placeholder="020" value="{{$country->country_code}}">
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="city" class="col-2 col-form-label">City</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="city" name="city_name_en"
                                       placeholder="Tanta" value="{{$city_details->city}}">
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
