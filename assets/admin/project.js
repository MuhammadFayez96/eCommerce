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
