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
                            <label for="country_name_en" class="col-2 col-form-label ">Country name in EN</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" name="country_name_en"
                                       placeholder="EX: Egypt">
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="country_name_ar" class="col-2 col-form-label ">Country name in AR </label>
                            <div class="col-10">
                                <input class="form-control required" type="text" name="country_name_ar"
                                       placeholder="مثلا: مصر">
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="country_code" class="col-2 col-form-label">Country Code</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="country_code" name="country_code"
                                       placeholder="EX: EG">
                            </div>
                        </div>
                    </div>


                    <h2 style="font-weight: bold;line-height: 1.5em;">Cities</h2>

                    <div class="row add_cities_section" style="position: relative;">
                        <div class="city_wrapper col-sm-12 row">

                            <div class="form-group col-sm-5">
                                <label for="city" class="col-2 col-form-label ">City name in EN</label>
                                <div class="col-10">
                                    <input class="form-control required" type="text"  name="city_name_en[]"
                                           placeholder="EX:Tanta">
                                </div>
                            </div>
                            <div class="form-group col-sm-5">
                                <label for="city" class="col-2 col-form-label ">City name in AR</label>
                                <div class="col-10">
                                    <input class="form-control required" type="text"  name="city_name_ar[]"
                                           placeholder="مثلا:طنطا ">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="add_cities btn btn-primary"
                                style="position: absolute; top: 25px;"
                                data-url="{{route('get-add-city-templates')}}">+</button>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer" style="text-align: center;">
                        <button type="submit" class="btn-submit btn btn-primary btn-sm btn-flat"
                        style="font-weight: bold; font-size: 16px; border-radius: 5px;">
                            Save <span class="glyphicon glyphicon-save"> </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('scripts')

<script>

$(document).ready(function() {

    var add_cities_template = '';

    $.ajax({
        url: $('.add_cities').data('url'),
        method: 'GET',
        async: false,
        success: function(result) {
            add_cities_template += result;
        }
    });

    $('.add_cities').on('click', function(event) {

        event.preventDefault();

        $('.add_cities_section').append(add_cities_template);

    });

    $(document).on('click', '.remove_city', function(event) {

        event.preventDefault();

        $(this).closest('.city_wrapper').remove();

    });

});

</script>

@endsection
