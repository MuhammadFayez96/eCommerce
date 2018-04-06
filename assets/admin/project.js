$(document).on('submit', ".update-form", function (e) {
    e.preventDefault();
    var $this = $(this);
    var url = $this.attr('action');
    var ajaxSubmit = $this.find('.btn-update-submit');
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
            console.log(data);
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
            console.log(data);
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
        error: function (xhr, status, error) {
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

$(document).on('click', '.add', function () {
    var html = '';
    html += '<tr>';
    html += '<td><div class="form-group col-sm-6"><label for="value" class="col-2 col-form-label ">value</label><div class="col-10"><input class="form-control" type="text" id="value" name="option_value_en[]" placeholder="EX: red"></div></div></td>';
    html += '<td><div class="form-group col-sm-6"><div class="col-10"><button type="button" name="remove" class="btn btn-danger btn-md remove">X </button></div></div></td></tr>';
    $('#field').append(html);
});

$(document).on('click', '.remove', function () {
    $(this).closest('tr').remove();
});


$(document).on('click', '.add_form', function () {
    var html = 'sss';
    html += '<tr>';
    html += '<td><div class="form-group col-sm-10"><div class="row"><div class="form-group col-sm-4"><label for="product" class="col-2 col-form-label">Products</label><div class="col-10"><select class="form-control" name="product_id" id="product"><option value="">Choose product:</option>@foreach($products as $product )<option value="{{$product->product_id}}">{{$product->name}}</option>@endforeach</select></div></div></div><div class="row"><div class="form-group col-sm-6"><label for="product_type" class="col-2 col-form-label">Product Type:</label><div class="col-10"><label class="radio-inline"><input type="radio" name="normal">Normal</label><label class="radio-inline"><input type="radio" name="option">Option</label></div></div></div><div class="row"><div class="form-group col-sm-6"><label for="amount" class="col-2 col-form-label ">Amount</label><div class="col-10"><input class="form-control" type="text" id="amount" name="amount[]"placeholder="20"></div></div><div class="form-group col-sm-6"><label for="cost" class="col-2 col-form-label">Cost</label><div class="col-10"><input class="form-control" type="text" id="cost"name="cost[]"placeholder="20"></div></div></div></div></td>';
    html += '<td><div class="form-group col-sm-6"><div class="col-10"><button type="button" name="remove" class="btn btn-danger btn-md remove">X </button></div></div></td></tr>';
    $('#form').append(html);
});


function normalProduct() {
    var selectBox = document.getElementById('type');
    var type = selectBox.options[selectBox.selectedIndex].value;
    if (type == 'normal') {
        document.getElementById('normal-product').style.visibility = 'visible';
        document.getElementById('option-product').style.visibility = 'hidden';
    } else if (type == 'option') {
        document.getElementById('normal-product').style.visibility = 'hidden';
        document.getElementById('option-product').style.visibility = 'visible';
    } else {
        document.getElementById('option-product').style.visibility = 'hidden';
    }

    return false;
}


function kash() {
    var kashRadio = document.getElementById('kashr');
    var type = $("#kashr").prop("checked", true);
    if (type = true) {
        $('.remain').attr("disabled", true);
    }
}

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

function cal() {
    var amount =$('input[name="amount[]"]').val();
    var cost =$('input[name="cost[]"]').val();

    var total_cost = amount * cost;
    console.log(total_cost);
    // $('#total_price').val(total_cost);
}

