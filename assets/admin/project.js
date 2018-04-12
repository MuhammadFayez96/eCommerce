$(document).on('submit', ".update-form", function (e) {

    e.preventDefault();
    var _this = $(this);
    var url = _this.attr('action');
    var ajaxSubmit = _this.find('.btn-update-submit');
    var formData = new FormData(this);
    if (_this.data('url') !== undefined) {
        url = _this.data('url');
    }

    $.ajax({
        url: url,
        type: 'POST',
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        },
        processData: false,
        data: formData,
        contentType: false,

        success: function (data) {

            if (data.status == 'success') {
                toastr["success"](data.text);
                location.reload(0);
            } else {
                //error code...
                toastr["error"](data.text);
            }
        },
        error: function (data) {
            toastr["error"](data.text);
        }

    });
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
});


$(document).on('submit', ".add-form", function (e) {
    e.preventDefault();
    var $this = $(this);
    var url = $this.attr('action');
    var ajaxSubmit = $this.find('.btn-submit');

    var formData = new FormData(this);
    if ($this.data('url') !== undefined) {
        url = $this.data('url');
    }
    $.ajax({
        url: url,
        type: 'POST',
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        },
        processData: false,
        data: formData,
        contentType: false,

        success: function (data) {
            // console.log(data);
            if (data.status == 'success') {
                toastr["success"](data.text);
                location.reload(0);
            } else {
                //error code...
                toastr["error"](data.text);
            }
        },
        error: function (data) {
            toastr["error"](data.text);
        }
    });
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
});

$('#delete').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    $('#url').val(button.data('url'));
    $('#delete_id').val(button.data('id'));
    $('#delete_token').val(button.data('token'));
});

function ajaxDelete(filename, token, content) {
    content = typeof content !== 'undefined' ? content : 'content';
    $.ajax({
        type: 'POST',
        data: {_method: 'DELETE', _token: token},
        url: filename,
        success: function (data) {
            $('#modalDelete').modal('hide');
            $("#" + content).html(data);
            toastr["success"](data.text);
            location.reload(0);
        },
        error: function (data, status, error) {
            toastr["error"](data.text);
        }
    });
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
}


//add value in option//
$(document).on('click', '.add-value', function () {
    var html = '';
    html += '<div class="addValue"><div class="form-group col-sm-5"><input class="form-control"'+
    ' type="text" name="option_value_en[]" placeholder="value in english"></div>'+
    '<div class="form-group col-sm-5"><input class="form-control" type="text" name="option_value_ar[]"'+
    ' placeholder="القيمه باللغه العربيه"></div><div class="form-group col-sm-2">'+
    '<button type="button" name="remove" class="btn btn-danger btn-md remove">X</button>'+
    '</div></div>';
    $('.addValueWrapper').append(html);
});

$(document).on('click', '.remove', function () {
    $(this).closest('.addValue').remove();
});
// end of add value //


//edit values in option //
$(document).on('click','.add-values',function(){
  var html='';
  html +='<div class="editValue"><div class="form-group col-sm-5"><input class=' +
  '"form-control" type="text" name="option_value_en[]" placeholder="value in ' +
  'english" data-value-id=""></div><div class="form-group col-sm-5"><input class=' +
  '"form-control" type="text" name="option_value_ar[]" placeholder="القيمة باللغة العربيه" data-value-id=""> ' +
  '</div><div class="form-group col-sm-2"><button type="button" name="value-remove" ' +
  'class="btn btn-danger btn-md value-remove2">X</button></div></div>';
  $('.editValuesWrapper').append(html);
});

$(document).on('click', '.value-remove2', function () {
  $(this).closest('.editValue').remove();
});

$(document).on('click', '.value-remove', function () {

  var option_value_id =  $(this).closest('.editValue').find("input[name='option_value_en[]']").first().data('value-id');
  var url = $(this).data('url');

  swal({
  title: "Are you sure?",
    text: "Once deleted, you will not be able to recover this imaginary file!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {

      $.ajax({
        url:url,
        method:'post',
        data:{
          option_value_id: option_value_id
        },
        success: function (data) {
            if (data.status == 'success') {
              $(this).closest('.editValue').remove();
              swal("Poof! Your imaginary file has been deleted!", {
                icon: "success",
              });
                location.reload(0);
            } else {
                //error code...
                toastr["error"](data.text);
            }
        },
        error: function (data) {
            toastr["error"]('Internal Server Error');
        }
      });
    } else {}
});
});
// end of edit value in option //

// function update option Value
$(document).on('click', '.btn-update-submit', function (e) {

    e.preventDefault();

    var option_values_en = [];
    var option_values_ar = [];

    var inputs_en = $("input[name='option_value_en[]']");

    inputs_en.each(function (key, item) {

      var value = $(this).val();

      var option_value_id =  $(this).data('value-id');

      option_values_en.push([value, option_value_id]);
    });

    var inputs_ar = $("input[name='option_value_ar[]']");

    inputs_ar.each(function (key, item) {

      var value = $(this).val();

      var option_value_id =  $(this).data('value-id');

      option_values_ar.push([value, option_value_id]);
    });

    var option_name_ar = $("input[name='option_name_ar']").val();
    var option_name_en = $("input[name='option_name_en']").val();

    var action_url = $(this).closest('form').attr('action');
    console.log(action_url);
    $.ajax({
      url: action_url,
      method: 'POST',
      data: {
        option_name_ar: option_name_ar,
        option_name_en: option_name_en,
        option_value_en: option_values_en,
        option_value_ar: option_values_ar,
      },
      success: function (data) {
          // console.log(data);
          if (data.status == 'success') {
              toastr["success"](data.text);
              location.reload(0);
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
// end of function //

//function for option in product//
$(document).on('click','.add-product-option',function(){
  var html='';
  html +='<div class="addProductOption"><div class="form-group col-sm-4"><label for="option" class="col-2 col-form-label">Option</label>'+
  '<div class="col-10"><select class="form-control" name="option" id="option">'+
'<option value="">Choose option:</option>@foreach($options as $option)<option value="{{$option->option_translated->option}}">{{$option->option_translated->option}}</option>@endforeach</select></div></div><div class="form-group col-sm-3">'+
'<label for="option_value" class="col-2 col-form-label">Option Value</label>'+
'<div class="col-10"><select class="form-control" name="option_value_id" id="option_value_id">'+
'<option value="">Choose option:</option><option value=""></option></select></div></div>'+
'<div class="form-group col-sm-3"><label for="price" class="col-2 col-form-label ">Price</label>'+
'<div class="col-10"><input class="form-control required" type="text" id="price" name="option_price" placeholder="10"></div>'+
'</div>';
html +='<div class="form-group col-sm-2"><label for="" class="col-2 col-form-label "></label>'+
'<div class="col-10"><button type="button"  name="remove-product-option" class="btn btn-danger btn-md remove-product-option">-</button></div></div></div></div>';

$('.addProductOptionWrapper').append(html);
});

$(document).on('click','.remove-product-option',function (){
    $(this).closest('.addProductOption').remove();
});



//end of it//







$(document).on('click', '.add_form', function () {
    var html = '';
    html += '<tr>';
    html += '<td><div class="form-group col-sm-10"><div class="row"><div class="form-group col-sm-4">'+
    '<label for="product" class="col-2 col-form-label">Products</label><div class="col-10">'+
    '<select class="form-control" name="product_id" id="product"><option value="">'+
    'Choose product:</option>@foreach($products as $product )<option value="{{$product->product_id}}">'+
    '{{$product->name}}</option>@endforeach</select></div></div></div><div class="row">'+
    '<div class="form-group col-sm-6"><labe for="product_type" class="col-2 col-form-label">'+
    'Product Type:</label><div class="col-10"><label class="radio-inline"><input type="radio" name="normal">'+
    'Normal</label><label class="radio-inline"><input type="radio" name="option">Option</label>'+
    '</div></div></div><div class="row"><div class="form-group col-sm-6"><label for="amount" class="col-2 col-form-label">'+
    'Amount</label><div class="col-10"><input class="form-control" type="text" id="amount" name="amount[]"placeholder="20">'+
    '</div></div><div class="form-group col-sm-6"><label for="cost" class="col-2 col-form-label">Cost</label><div class="col-10">'+
    '<input class="form-control" type="text" id="cost"name="cost[]"placeholder="20">'+
    '</div></div></div></div></td>';
    html += '<td><div class="form-group col-sm-6"><div class="col-10"><button type="button" name="remove" class="btn btn-danger btn-md remove">X </button></div></div></td></tr>';
    $('#form').append(html);
});


// function Product() {
//     var selectBox = document.getElementById('type');
//     var type = selectBox.options[selectBox.selectedIndex].value;
//     if (type == 'normal') {
//         document.getElementById('normal-product').style.visibility = 'visible';
//         document.getElementById('option-product').style.visibility = 'hidden';
//     } else if (type == 'option') {
//         document.getElementById('normal-product').style.visibility = 'hidden';
//         document.getElementById('option-product').style.visibility = 'visible';
//     } else {
//         document.getElementById('option-product').style.visibility = 'hidden';
//     }
//
//     return false;
// }


// cash
function kash() {
    var kashRadio = document.getElementById('kashr');
    var type = $("#kashr").prop("checked", true);
    if (type = true) {
        $('.remain').attr("disabled", true);
    }
}

//remaining
function ba2y() {
    var ba2yRadio = document.getElementById('ba2yr');
    var type = $("#ba2yr").prop("checked", true);
    if (type = true) {
        $('.remain').removeAttr('disabled');
    }
}

$(document).on('change', '#total', function () {
    cal();
});
//
// function cal() {
//     var amount =$('input[name="amount[]"]').val();
//     var cost =$('input[name="cost[]"]').val();
//
//     var total_cost = amount * cost;
//     console.log(total_cost);
//     // $('#total_price').val(total_cost);
// }



//
$(document).on('click','.add_fields',function(){
    var html='';

    $.ajax({
        url: $(this).data('url'),
        method: 'GET',
        success: function (result) {
            html += result;
            $('.addOptionWrapper').append(html);

            $(document).ready(function () {
                $('.selectpicker').selectpicker();
            });

        }
    });

});

$(document).on('click','.remove_fields',function(){
    var v =$(this).closest('.addOption').remove();
    console.log(v);
});
// end

//
$(document).on('click','.add_product_form',function(){
    var html = '';

    $.ajax({
        url: $(this).data('url'),
        method: 'GET',
        success: function (result) {
            html += result;
            $('.boughtsWrapper').append(html);
        }
    });
});

$(document).on('click','.remove_product_form',function(){
    $(this).closest('.bought').remove();
});
// end


function showComponent()
{
    var product_type = $("#product").find(':selected').attr('data-product-type');

    if (product_type == 'normal'){
        $(".productNormalWrapper").removeClass("hidden");
        $(".ProductOptionWrapper").addClass("hidden");

    }else{
        $(".ProductOptionWrapper").removeClass("hidden");
        $(".productNormalWrapper").addClass("hidden");

    }
}
