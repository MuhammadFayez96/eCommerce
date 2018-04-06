@extends('admin.master')

@section('content-header')
    <section class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><h4>Addresses</h4></li>
                <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('addresses')}}">Addresses</a></li>
                <li class="breadcrumb-item"><a href="{{url('addresses/get-create')}}">Add Addresses</a>
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

            <form action="{{route('admin.addresses.createNewAddress')}}" class="add-form" enctype="multipart/form-data"
                  method="post"
                  onsubmit="return false;">
                {!! csrf_field() !!}
                <div class="modal-body">

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="country" class="col-2 col-form-label ">Country</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="country" name="country_name_en"
                                       placeholder="EX: Egypt">
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="country_code" class="col-2 col-form-label">Country Code</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="country_code" name="country_code"
                                       placeholder="+020">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="city" class="col-2 col-form-label ">City</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="city" name="city_name_en"
                                       placeholder="EX:Tanta">
                            </div>
                        </div>
                    </div>

                    {{--<input class="form-control required" type="hidden" id="country_id" name="country_id" value="{{$country->id}}" required>--}}

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
