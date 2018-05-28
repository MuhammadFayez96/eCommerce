<div class="bought col-sm-12 row" style="margin-bottom: 35px;">

    <!-- product div -->
    <div class="row col-sm-12">
        <div class="form-group col-sm-4">
            <label style="font-size: 30px; font-family: 'Source Sans Pro',sans-serif; font-weight: 500; color: #FF4136;" >product</label>
            <select class="form-control product-slecet" data-live-search="true" name="products[]" onchange="handleProductChange(event)">
                @foreach($products as $product )
                    <option data-type="{{$product->type}}" value="{{$product->id}}">{{$product->trans->name}}</option>
                @endforeach
            </select>
        </div>

        <!-- div plus button -->
        <div class="form-group col-sm-2" style="margin-top: 45px;">
            <div class="col-10"  style="display: inline-block;">
                <button type="button" name="add_product_form"
                        data-url = "{{route('admin.boughts.getBoughtSectionView')}}"
                        class="btn btn-primary btn-md add_product_form">+
                </button>
            </div>

            <div class="col-10" style="display: inline-block;">
                <button type="button" name="remove_product_form"
                        class="btn btn-danger btn-md remove_product_form">-
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
                           name="price"
                           placeholder="price">
                </div>
            </div>
            <!-- end price div -->

            <!-- serial div  -->
            <div class="form-group col-sm-4">
                <label for="serial" class="col-2 col-form-label ">Serial</label>
                <div class="col-10">
                    <input class="form-control" type="text" class="serial"
                           name="serial"
                           placeholder="serial">
                </div>
            </div>
            <!-- end serial div -->

            <!-- model number div -->
            <div class="form-group col-sm-4">
                <label for="model_number" class="col-2 col-form-label ">Model Number</label>
                <div class="col-10">
                    <input class="form-control" type="text" class="model_number"
                           name="model_number"
                           placeholder="model number">
                </div>
            </div>
            <!-- end model number div -->

            <!-- barcode div -->
            <div class="form-group col-sm-4">
                <label for="barcode" class="col-2 col-form-label ">Barcode</label>
                <div class="col-10">
                    <input class="form-control" type="text" class="barcode"
                           name="barcode"
                           placeholder="barcode">
                </div>
            </div>
            <!-- end barcode div -->

            <!-- discount div -->
            <div class="form-group col-sm-4">
                <label for="discount" class="col-2 col-form-label ">Discount</label>
                <div class="col-10">
                    <input class="form-control" type="text" class="discount"
                           name="discount"
                           placeholder="discount">
                </div>
            </div>
            <!-- end discount div -->

            <!-- stock div -->
            <div class="form-group col-sm-4">
                <label for="stock" class="col-2 col-form-label ">Stock</label>
                <div class="col-10">
                    <input class="form-control" type="text" class="stock"
                           name="stock"
                           placeholder="stock">
                </div>
            </div>
            <!-- end stock div -->

            <!-- discount type div -->
            <div class="form-group col-sm-4">
                <label for="discount_type" class="col-2 col-form-label ">Discount Type</label>
                <div class="col-10">
                    <input class="form-control" type="text" class="discount_type"
                           name="discount_type"
                           placeholder="discount type">
                </div>
            </div>
            <!-- end discount type div -->

            <!-- amount div -->
            <div class="form-group col-sm-4">
                <label for="amount" class="col-2 col-form-label ">Amount</label>
                <div class="col-10">
                    <input class="form-control" type="text" class="amount"
                           name="amount" id="normalAmount"
                           placeholder="20">
                </div>
            </div>
            <!-- end amount div -->

            <!-- cost div -->
            <div class="form-group col-sm-4">
                <label for="cost" class="col-2 col-form-label ">cost</label>
                <div class="col-10">
                    <input class="form-control" type="text" class="cost"
                           name="cost"
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
                            <select class="selectpicker" name="option_values[]" class="option_values" multiple  data-selected-text-format="count > 3">

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
                                   name="prices[]"
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
                           name="serial"
                           placeholder="serial">
                </div>
            </div>
            <!-- end serial div -->

            <!-- model number div  -->
            <div class="form-group col-sm-4">
                <label for="model_number" class="col-2 col-form-label ">Model Number</label>
                <div class="col-10">
                    <input class="form-control" type="text" class="model_number"
                           name="model_number"
                           placeholder="model number">
                </div>
            </div>
            <!-- end model number div -->

            <!-- barcode div -->
            <div class="form-group col-sm-4">
                <label for="barcode" class="col-2 col-form-label ">Barcode</label>
                <div class="col-10">
                    <input class="form-control" type="text" class="barcode"
                           name="barcode"
                           placeholder="barcode">
                </div>
            </div>
            <!-- end barcode div -->

            <!-- discount div -->
            <div class="form-group col-sm-4">
                <label for="discount" class="col-2 col-form-label ">Discount</label>
                <div class="col-10">
                    <input class="form-control" type="text" class="discount"
                           name="discount"
                           placeholder="discount">
                </div>
            </div>
            <!-- end discount div -->

            <!-- stock div -->
            <div class="form-group col-sm-4">
                <label for="stock" class="col-2 col-form-label ">Stock</label>
                <div class="col-10">
                    <input class="form-control" type="text" class="stock"
                           name="stock"
                           placeholder="stock">
                </div>
            </div>
            <!-- end stock div -->

            <!-- amount div -->
            <div class="form-group col-sm-4">
                <label for="amount" class="col-2 col-form-label ">Amount</label>
                <div class="col-10">
                    <input class="form-control" type="text" class="amount"
                           name="amount" id="optionAmount"
                           placeholder="amount">
                </div>
            </div>
            <!-- end amount div -->
        </div>
        <!-- end class productOption div -->
    </div>
    <!-- end class ProductOptionWrapper div -->
</div>
