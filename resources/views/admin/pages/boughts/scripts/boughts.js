$('.selectpicker').selectpicker();


//-------------------------------------------------------------//
     // handelProductChange function
//------------------------------------------------------------//
function handleProductChange(event) {

    // cast js element to jquery element
    var _this = $(event.target);
    var type = _this.find(':selected').data('type');

    if (type == 'normal') {

        _this.closest('.bought').find('.productNormalWrapper').removeClass('hidden');
        _this.closest('.bought').find('.productOptionWrapper').removeClass('hidden').addClass('hidden');

        console.log();
    } else {
        _this.closest('.bought').find('.productNormalWrapper').removeClass('hidden').addClass('hidden');
        _this.closest('.bought').find('.productOptionWrapper').removeClass('hidden');
    }
}
//------------------------------------------------------//
                 //end of function
//------------------------------------------------------//


//-------------------------------------------------------------//
     // handelOptionChange function
//------------------------------------------------------------//
function handleOptionChange(event) {

    var _this = $(event.target);
    var url = _this.find(':selected').data('url');

    $.ajax({
        url: url,
        method:"GET",
        success:function(result){

            _this.closest('.addOption').find('select').last().empty().html(result).selectpicker('refresh');

        }
    });
}
//------------------------------------------------------//
                 //end of function
//------------------------------------------------------//


//-------------------------------------------------------------//
     // cache and remainder radio button section in bought page
//------------------------------------------------------------//

//-------------------Cache function --------------------//
function Cache() {
    var cache_type = $("input:radio[class='cache']").is(":checked");
    var remain = $("input[name='remain']");
    if(cache_type){
        remain.prop('disabled', true);
    }
}

//-------------------Remainder function --------------------//
function Remainder() {
    var remainder_type = $("input:radio[class='remainder']").is(":checked");
    var remain = $("input[name='remain']");
    if(remainder_type){
        remain.removeAttr("disabled");
    }
}
//------------------------------------------------------//
                 //end of function
//------------------------------------------------------//


//--------------------------------------------------//
     // add option section in bought page
//--------------------------------------------------//
$(document).on('click','.add_option_section',function(){
    var html='';
    $.ajax({
        url: $(this).data('url'),
        method: 'GET',
        success: function (result) {
            html += result;
            $('.addOptionWrapper').append(html);

            $('.selectpicker').selectpicker();
        }
    });
});

//-------------------Remove section --------------------//
$(document).on('click','.remove_option_section',function(){
    $(this).closest('.addOption').remove();
});
//------------------------------------------------------//
                 //end of function
//------------------------------------------------------//


//--------------------------------------------------//
     // add prodcut section in bought page
//--------------------------------------------------//
$(document).on('click','.add_product_section',function(){
    var html = '';

    var products = $("select[name='products[]']");
    var normal = [];
    var option = [];

    products.each(function(key, item){
        var normal_amount = $(this).closest('.bought').find('.productNormalWrapper').find("input[name='amount']").val();
        var option_amount = $(this).closest('.bought').find('.productOptionWrapper').find("input[name='amount']").val()
        normal.push(normal_amount);
        option.push(option_amount);
    });

    var total_normal = 0;
    for (var i = 0; i < normal.length; i++) {
        total_normal += parseInt(normal[i]);

    }

    var total_option = 0;
    for (var i = 0; i < option.length; i++) {
        total_option += parseInt(option[i]);
    }

    // var total = parseInt(total_normal) + parseInt(total_option);
    console.log("normal"+total_normal);
    console.log("option"+total_option);

    // $('#totalAmount').prop('value',total);


    $.ajax({
        url: $(this).data('url'),
        method: 'GET',
        success: function (result) {
            html += result;
            $('.boughtsWrapper').append(html);

            $('.selectpicker').selectpicker();
        }
    });
});

//-------------------Remove section --------------------//
$(document).on('click','.remove_product_form',function(){
    $(this).closest('.bought').remove();
});
//------------------------------------------------------//
                 //end of function
//------------------------------------------------------//


$('#normalAmount').keyup(function(){
    $('#totalAmount').prop('value',$(this).val());
});


$('#optionAmount').keyup(function(){
    $('#totalAmount').prop('value',$(this).val());
});



$(document).on('click', '.btn-add-submit', function(e){
    e.preventDefault();

    var products = $("select[name='products[]']");

    var action_url = $(this).closest('form').attr('action');

    var data = [];
    var mainBought = [];
    var normal_products = [];
    var option_products = [];

    var mainBoughts = {
        user_id:  $("select[name='role_id']").val(),
        bought_type: $("input:radio[name='bought_type']:checked").val(),
        total_price: $("input[name='total_price']").val(),
        total_amount: $("input[name='total_amount']").val(),
        paid: $("input[name='paid']").val(),
        remain: $("input[name='remain']").val()
    };

    mainBought.push([mainBoughts]);

    products.each(function(key, item){

        type = $(this).find(':selected').data('type');

        if(type == 'normal'){

            var data_normal_object = {
                id: $(this).find(':selected').val(),
                type: $(this).find(':selected').data('type'),
                price: $(this).closest('.bought').find('.productNormalWrapper').find("input[name='price']").val(),
                serial: $(this).closest('.bought').find('.productNormalWrapper').find("input[name='serial']").val(),
                model_number: $(this).closest('.bought').find('.productNormalWrapper').find("input[name='model_number']").val(),
                barcode: $(this).closest('.bought').find('.productNormalWrapper').find("input[name='barcode']").val(),
                discount: $(this).closest('.bought').find('.productNormalWrapper').find("input[name='discount']").val(),
                stock: $(this).closest('.bought').find('.productNormalWrapper').find("input[name='stock']").val(),
                discount_type: $(this).closest('.bought').find('.productNormalWrapper').find("input[name='discount_type']").val(),
                amount: $(this).closest('.bought').find('.productNormalWrapper').find("input[name='amount']").val(),
                cost: $(this).closest('.bought').find('.productNormalWrapper').find("input[name='cost']").val(),
            };

            normal_products.push([data_normal_object]);

        }else
        {
            var options_array = [];

            var options = $(this).closest('.bought').find('.productOptionWrapper').find('.addOption').find("select[name='options[]']");
            var option_values = $(this).closest('.bought').find('.productOptionWrapper').find('.addOption').find("select[name='option_values[]']");
            var prices = $(this).closest('.bought').find('.productOptionWrapper').find('.addOption').find("input[name='prices[]']");

            var opts = [];
            var vals = [];
            var prcs = [];

            options.each(function (key, item){
                opts.push($(this).val());
            });

            option_values.each(function (key, item){
                vals.push($(this).val());
            });

            prices.each(function (key, item){
                prcs.push($(this).val());
            });

            var array_of_options = {
                options: opts,
                option_values: vals,
                prices: prcs
            };

            options_array.push(array_of_options);

            var data_option_object ={
                id: $(this).find(':selected').val(),
                options_array: options_array,
                serial: $(this).closest('.bought').find('.productOptionWrapper').find("input[name='serial']").val(),
                model_number: $(this).closest('.bought').find('.productOptionWrapper').find("input[name='model_number']").val(),
                barcode: $(this).closest('.bought').find('.productOptionWrapper').find("input[name='barcode']").val(),
                discount: $(this).closest('.bought').find('.productOptionWrapper').find("input[name='discount']").val(),
                stock: $(this).closest('.bought').find('.productOptionWrapper').find("input[name='stock']").val(),
                amount: $(this).closest('.bought').find('.productOptionWrapper').find("input[name='amount']").val(),
            };

            option_products.push([data_option_object]);
        }
    });

    $.ajax({
        url: action_url,
        method: 'POST',
        data:{
            mainBought: mainBought,
            normal_products: normal_products,
            option_products: option_products
        },
        success: function(data) {
            if (data.status == 'success') {
                toastr["success"](data.text);
                location.reload(0);
            } else {
                //error code...
                toastr["error"](data.text);
            }
        },
        error:function (data) {
            toastr["error"](data.text);
        }
    });
});
