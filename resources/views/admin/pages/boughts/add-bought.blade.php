@extends('admin.master')

@section('content-header')
    <section class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><h4>Boughts</h4></li>
                <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('boughts')}}">Boughts</a></li>
                <li class="breadcrumb-item"><a href="{{url('boughts/get-create')}}">Add Boughts</a></li>
            </ol>
        </nav>
    </section>
@endsection

@section('content')

    <section class="content">
        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading" style="font-size: large">Boughts</div>

            <form action="{{ route('admin.boughts.createNewBought') }}" onsubmit="return false;" method="post"
                  class="add-form">

                {!! csrf_field() !!}

                <div class="panel-body">

                    <!-- first div row -->
                    <div class="row">
                        <!-- users div  -->
                        <div class="form-group col-sm-6">
                            <label for="role" class="col-2 col-form-label">Users</label>
                            <div class="col-10">
                                <select class="form-control" name="role_id" class="role">
                                    <option value="{{$role->id}}">{{$role->role}}</option>
                                </select>
                            </div>
                        </div>
                        <!-- end users div -->

                        <!-- bought type div  -->
                        <div class="form-group col-sm-6">
                            <label for="bought_type" class="col-2 col-form-label">Bought Type</label>
                            <div class="col-10">
                                <label class="radio-inline"><input type="radio" name="bought_type" class="cache" onchange="return Cache();">Cache</label>
                                <label class="radio-inline"><input type="radio" name="bought_type" class="remainder" onchange="return Remainder();">Remainder</label>
                            </div>
                        </div>
                        <!-- end bought type div  -->
                    </div>
                    <!-- end first div row  -->

                    <!-- secound div row -->
                    <div class="row">
                        <!-- total price  div -->
                        <div class="form-group col-sm-6">
                            <label for="total_price" class="col-2 col-form-label ">Total Price</label>
                            <div class="col-10">
                                <input class="form-control" type="text" class="total_price" name="total_price"
                                       placeholder="total price">
                            </div>
                        </div>
                        <!-- end total price div -->

                        <!-- total amount div  -->
                        <div class="form-group col-sm-6">
                            <label for="total_amount" class="col-2 col-form-label">Total Amount</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" class="total_amount"
                                       name="total_amount"
                                       placeholder="total amount">
                            </div>
                        </div>
                        <!-- end total amount div  -->
                    </div>
                    <!-- end secound div row  -->

                    <!-- third div row  -->
                    <div class="row">
                        <!-- paid div  -->
                        <div class="form-group col-sm-6">
                            <label for="paid" class="col-2 col-form-label ">Paid</label>
                            <div class="col-10">
                                <input class="form-control" type="text" class="paid" name="paid"
                                       placeholder="paid">
                            </div>
                        </div>
                        <!-- end paid div -->

                        <!-- remain div  -->
                        <div class="form-group col-sm-6" >
                            <label for="remain" class="col-2 col-form-label">Remain</label>
                            <div class="col-10">
                                <input class="form-control" type="text" class="remain"
                                       name="remain"
                                       placeholder="remain">
                            </div>
                        </div>
                        <!-- end remain div -->
                    </div>
                    <!-- end third row -->

                    <hr style="border: 0; height: 3px; background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));">

                    <!-- boughtsWrapper div -->
                    <div class="boughtsWrapper row">
                        <!-- bought div  -->
                        <div class="bought col-sm-12 row" style="margin-bottom: 35px;">

                            <!-- product div -->
                            <div class="row col-sm-12">
                                <div class="form-group col-sm-4">
                                    <label style="font-size: 30px; font-family: 'Source Sans Pro',sans-serif; font-weight: 500; color: #FF4136;">product</label>
                                    <select class="form-control selectpicker" data-live-search="true" name="products[]" onchange="handleProductChange(event)">
                                        @foreach($products as $product )
                                            <option data-type="{{$product->type}}" value="{{$product->id}}">{{$product->trans->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- div plus button -->
                                <div class="form-group col-sm-2" style="margin-top: 45px;">
                                    <div class="col-10">
                                        <button type="button" name="add_product_form"
                                                data-url = "{{route('admin.boughts.getBoughtSectionView')}}"
                                                class="btn btn-primary btn-md add_product_form">+
                                        </button>
                                    </div>
                                </div>
                                <!-- end div plus button  -->

                            </div>
                            <!-- end product div -->

                            <!-- productNormalWrapper div -->
                            <div class="productNormalWrapper
                            {{$products->first()->type == 'option'? 'hidden' : ''}}">
                                <!-- productNormal div  -->
                                <div class="productNormal col-sm-12">

                                    <!-- price div  -->
                                    <div class="form-group col-sm-4">
                                        <label for="price" class="col-2 col-form-label ">Price</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" class="price"
                                                   name="price[]"
                                                   placeholder="price">
                                        </div>
                                    </div>
                                    <!-- end price div -->

                                    <!-- serial div  -->
                                    <div class="form-group col-sm-4">
                                        <label for="serial" class="col-2 col-form-label ">Serial</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" class="serial"
                                                   name="serial[]"
                                                   placeholder="serial">
                                        </div>
                                    </div>
                                    <!-- end serial div -->

                                    <!-- model number div -->
                                    <div class="form-group col-sm-4">
                                        <label for="model_number" class="col-2 col-form-label ">Model Number</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" class="model_number"
                                                   name="model_number[]"
                                                   placeholder="model number">
                                        </div>
                                    </div>
                                    <!-- end model number div -->

                                    <!-- barcode div -->
                                    <div class="form-group col-sm-4">
                                        <label for="barcode" class="col-2 col-form-label ">Barcode</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" class="barcode"
                                                   name="barcode[]"
                                                   placeholder="barcode">
                                        </div>
                                    </div>
                                    <!-- end barcode div -->

                                    <!-- discount div -->
                                    <div class="form-group col-sm-4">
                                        <label for="discount" class="col-2 col-form-label ">Discount</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" class="discount"
                                                   name="discount[]"
                                                   placeholder="discount">
                                        </div>
                                    </div>
                                    <!-- end discount div -->

                                    <!-- stock div -->
                                    <div class="form-group col-sm-4">
                                        <label for="stock" class="col-2 col-form-label ">Stock</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" class="stock"
                                                   name="stock[]"
                                                   placeholder="stock">
                                        </div>
                                    </div>
                                    <!-- end stock div -->

                                    <!-- discount type div -->
                                    <div class="form-group col-sm-4">
                                        <label for="discount_type" class="col-2 col-form-label ">Discount Type</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" class="discount_type"
                                                   name="discount_type[]"
                                                   placeholder="discount type">
                                        </div>
                                    </div>
                                    <!-- end discount type div -->

                                    <!-- amount div -->
                                    <div class="form-group col-sm-4">
                                        <label for="amount" class="col-2 col-form-label ">Amount</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" class="amount"
                                                   name="amount[]"
                                                   placeholder="20">
                                        </div>
                                    </div>
                                    <!-- end amount div -->

                                    <!-- cost div -->
                                    <div class="form-group col-sm-4">
                                        <label for="cost" class="col-2 col-form-label ">cost</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" class="cost"
                                                   name="cost[]"
                                                   placeholder="cost">
                                        </div>
                                    </div>
                                    <!-- end cost div -->
                                </div>
                                <!-- end class productNormal div  -->
                            </div>
                            <!-- end class productNormalWrapper div -->

                            <!-- ProductOptionWrapper div -->
                            <div class="productOptionWrapper
                            {{$products->first()->type == 'normal'? 'hidden' : ''}}">


                                <!-- ProductOption div -->
                                <div class="productOption col-sm-12">
                                    <h2>options</h2>

                                    <!-- addOptionWrapper div row -->
                                    <div class="addOptionWrapper row" style="margin-bottom: 30px;">
                                        <!-- addOption div -->
                                        <div class="addOption col-sm-12">

                                            <!-- options div -->
                                            <div class="form-group col-sm-4">
                                                <label for="options" class="col-2 col-form-label">option</label>
                                                <div class="col-10">
                                                    <select class="form-control" name="options[]" class="options"
                                                    onchange="handleOptionChange(event)">
                                                        @foreach($options as $option)
                                                            <option
                                                            data-url="{{route('admin.boughts.getOptionValues', ['id' => $option->id])}}"
                                                            value="{{$option->id}}">{{$option->trans->option}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- end options div -->

                                            <!--  option values div -->
                                            <div class="form-group col-sm-3">
                                                <label for="option_values" class="col-2 col-form-label">option values</label>
                                                <div class="col-10">
                                                    <select class="selectpicker" name="option_values" class="option_values" multiple  data-selected-text-format="count > 3">

                                                        @foreach($options->first()->values as $value)

                                                            <option value="{{$value->id}}">{{$value->trans->value}}</option>

                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                            <!-- end option values div -->

                                            <!-- price div  -->
                                            <div class="form-group col-sm-3" >
                                                <label for="price" class="col-2 col-form-label">price</label>
                                                <div class="col-10">
                                                    <input class="form-control" type="text" class="price"
                                                           name="price[]"
                                                           placeholder="price">
                                                </div>
                                            </div>
                                            <!-- end price div -->

                                            <!-- add button for new option section div  -->
                                            <div class="form-group col-sm-2">
                                                <label for="" class="col-2 col-form-label"></label>
                                                <div class="col-10">
                                                    <button type="button" name="add_option_section"
                                                    data-url="{{route('admin.boughts.getOptionSectionView')}}"
                                                            class="btn btn-primary btn-md add_option_section">+
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- end add button div -->
                                        </div>
                                        <!-- end class addOption div  -->
                                    </div>
                                    <!-- end class addOptionWrapper div -->

                                    <!-- serial div -->
                                    <div class="form-group col-sm-4">
                                        <label for="serial" class="col-2 col-form-label ">Serial</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" class="serial"
                                                   name="serial[]"
                                                   placeholder="serial">
                                        </div>
                                    </div>
                                    <!-- end serial div -->

                                    <!-- model number div  -->
                                    <div class="form-group col-sm-4">
                                        <label for="model_number" class="col-2 col-form-label ">Model Number</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" class="model_number"
                                                   name="model_number[]"
                                                   placeholder="model number">
                                        </div>
                                    </div>
                                    <!-- end model number div -->

                                    <!-- barcode div -->
                                    <div class="form-group col-sm-4">
                                        <label for="barcode" class="col-2 col-form-label ">Barcode</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" class="barcode"
                                                   name="barcode[]"
                                                   placeholder="barcode">
                                        </div>
                                    </div>
                                    <!-- end barcode div -->

                                    <!-- discount div -->
                                    <div class="form-group col-sm-4">
                                        <label for="discount" class="col-2 col-form-label ">Discount</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" class="discount"
                                                   name="discount[]"
                                                   placeholder="discount">
                                        </div>
                                    </div>
                                    <!-- end discount div -->

                                    <!-- stock div -->
                                    <div class="form-group col-sm-4">
                                        <label for="stock" class="col-2 col-form-label ">Stock</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" class="stock"
                                                   name="stock[]"
                                                   placeholder="stock">
                                        </div>
                                    </div>
                                    <!-- end stock div -->

                                    <!-- amount div -->
                                    <div class="form-group col-sm-4">
                                        <label for="amount" class="col-2 col-form-label ">Amount</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" class="amount"
                                                   name="amount[]"
                                                   placeholder="amount">
                                        </div>
                                    </div>
                                    <!-- end amount div -->
                                </div>
                                <!-- end class productOption div -->
                            </div>
                            <!-- end class ProductOptionWrapper div -->
                        </div>
                        <!-- end class bought div -->

                    </div>
                    <!-- end class boughtsWrapper div -->

                    <!-- footer div -->
                    <div class="modal-footer">
                        <button type="submit" class="btn-submit btn btn-primary btn-md btn-flat">
                            Save <span class="glyphicon glyphicon-save"> </span>
                        </button>
                    </div>
                    <!-- end footer div -->
                </div>
                <!-- end div panel-body -->
            </form>
            <!-- end form -->
        </div>
        <!-- end panel div -->
    </section>
    <!-- end section -->
@endsection

@section('scripts')

<script>

$('.selectpicker').selectpicker();

function handleProductChange(event) {

    // cast js element to jquery element
    var _this = $(event.target);
    var type = _this.find(':selected').data('type');

    console.log(type);

    if (type == 'normal') {

        _this.closest('.bought').find('.productNormalWrapper').removeClass('hidden');
        _this.closest('.bought').find('.productOptionWrapper').removeClass('hidden').addClass('hidden');

        console.log();
    } else {
        _this.closest('.bought').find('.productNormalWrapper').removeClass('hidden').addClass('hidden');
        _this.closest('.bought').find('.productOptionWrapper').removeClass('hidden');
    }

}


function handleOptionChange(event) {

    var _this = $(event.target);
    var url = _this.find(':selected').data('url');

    console.log(url);

    $.ajax({
        url: url,
        method:"GET",
        success:function(result){

            _this.closest('.addOption').find('select').last().empty().html(result).selectpicker('refresh');

        }
    });


}

</script>

@endsection
