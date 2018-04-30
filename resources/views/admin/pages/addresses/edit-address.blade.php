@extends('admin.master')

@section('styles')

<style>

input[name='city_name_ar[]'],  input[name='country_name_ar']{
    text-align: right;
}

</style>

@endsection

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

            <form action="{{route('admin.addresses.updateAddress')}}" class="add-form" enctype="multipart/form-data"
                  method="post"
                  onsubmit="return false;">
                {!! csrf_field() !!}

                <input type="hidden" name="country_id" value="{{$country->id}}">

                <div class="modal-body">

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="country_name_en" class="col-2 col-form-label ">Country name in EN</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" name="country_name_en" value="{{$country->en->country}}"
                                       placeholder="EX: Egypt">
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="country_name_ar" class="col-2 col-form-label" style="float: right;">اسم الدولة باللغة العربيه</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" name="country_name_ar" value="{{$country->ar->country}}"
                                       placeholder="مثلا: مصر">
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="country_code" class="col-2 col-form-label">Country Code</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="country_code" name="country_code" value="{{$country->country_code}}"
                                       placeholder="EX: EG">
                            </div>
                        </div>
                    </div>


                    <div class="citiy-head row" style="position: relative;">

                        <div class="col-md-10">

                            <h2 style="font-weight: bold;line-height: 1.5em;">Cities</h2>

                        </div>

                        <div class="col-md-2">

                            <div class="col-sm-2">
                                <button type="button" class="add_cities btn btn-primary"
                                style="position: absolute; top: 25px; right: 20px;"
                                data-url="{{route('get-add-city-templates')}}">+</button>
                            </div>

                        </div>

                    </div>


                        <div class="row add_cities_section" style="position: relative;">
                            @foreach($country->cities as $city)
                            <div class="city_wrapper col-sm-12 row">

                                <div class="form-group col-sm-5">
                                    <label for="city" class="col-2 col-form-label ">City name in EN</label>
                                    <div class="col-10">
                                        <input class="form-control required" type="text"  name="city_name_en[]" value="{{$city->en->city}}"
                                        data-cityid={{$city->id}}
                                               placeholder="EX:Tanta">
                                    </div>
                                </div>
                                <div class="form-group col-sm-5">
                                    <label for="city" class="col-2 col-form-label" style="float: right;">اسم المدينة باللغة العربيه</label>
                                    <div class="col-10">
                                        <input class="form-control required" type="text"  name="city_name_ar[]" value="{{$city->ar ? $city->ar->city : ''}}"
                                        data-cityid={{$city->id}}
                                               placeholder='مثلا: طنطا'>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="remove_city btn btn-danger"
                                    style="position: absolute; top: 25px;"
                                    data-url="{{route('delete-city', ['id' => $city->id])}}"
                                    data-old="y">X</button>
                                </div>

                            </div>
                            @endforeach

                            <div class="city_wrapper col-sm-12 row">

                                <div class="form-group col-sm-5">
                                    <label for="city" class="col-2 col-form-label ">City name in EN</label>
                                    <div class="col-10">
                                        <input class="form-control required" type="text"  name="city_name_en[]"
                                               placeholder="EX:Tanta">
                                    </div>
                                </div>
                                <div class="form-group col-sm-5">
                                    <label for="city" class="col-2 col-form-label" style="float: right;">اسم المدينة باللغة العربيه</label>
                                    <div class="col-10">
                                        <input class="form-control required" type="text"  name="city_name_ar[]"
                                               placeholder="مثلا:طنطا ">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="remove_city btn btn-danger"
                                    style="position: absolute; top: 25px;"
                                    data-old="n">X</button>
                                </div>

                            </div>

                        </div>



                    <div class="modal-footer" style="text-align: center;">
                        <button type="button" class="btn-update-country-submit btn btn-primary btn-sm btn-flat"
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

        var _this = $(this);

        if (_this.data('old') == 'n') {

            _this.closest('.city_wrapper').remove();
        } else {

            swal({
              title: "Are you sure?",
              text: "Once deleted, you will not be able to recover this imaginary file!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {

                  $.ajax({
                      url: _this.data('url'),
                      method: 'GET',
                      success: function() {
                          swal("Poof! Your imaginary file has been deleted!", {
                            icon: "success",
                          });
                          _this.closest('.city_wrapper').remove();
                      }
                  });

              } else {
                swal("Your imaginary file is safe!");
              }
            });
        }
    });
});

</script>

<script>

// function update option Value
$(document).on('click', '.btn-update-country-submit', function (e) {

    e.preventDefault();

    var cities_en = [];
    var cities_ar = [];

    var inputs_en = $("input[name='city_name_en[]']");

    inputs_en.each(function (key, item) {

     if ($(this).val()) {

         var value = $(this).val();

         var city_id =  $(this).data('cityid');

         cities_en.push([value, city_id]);
     }

    });


    var inputs_ar = $("input[name='city_name_ar[]']");

    inputs_ar.each(function (key, item) {

        if ($(this).val()) {
            var value = $(this).val();

            var city_id =  $(this).data('cityId');

            cities_ar.push([value, city_id]);
        }

    });

    var country_ar = $("input[name='country_name_ar']").val();
    var country_en = $("input[name='country_name_en']").val();
    var country_code = $("input[name='country_code']").val();


    var action_url = $(this).closest('form').attr('action');

    $.ajax({
      url: action_url,
      method: 'POST',
      data: {
        country_id: $("input[name='country_id']").val(),
        country_name_ar: country_ar,
        country_name_en: country_en,
        country_code: country_code,
        cities_names_en: cities_en,
        cities_names_ar: cities_ar,
      },
      success: function (data) {
          // console.log(data);
          if (data.status == 'success') {
              toastr["success"](data.text);
              setTimeout(function() {
                location.reload(0);
              }, 2000);
          } else {
              //error code...
              toastr["error"](data.text);
          }
      },
      error: function (data) {
          toastr["error"](data.text);
      }
    });
});

</script>

@endsection
