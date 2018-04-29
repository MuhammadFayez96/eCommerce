<!-- bought div  -->
<div class="bought col-sm-12 row">
    <!-- product div -->
    <div class="form-group col-sm-4">
        <label for="product" class="col-2 col-form-label">Products</label>
        <div class="col-10">
            <select class="form-control selectpicker" data-live-search="true" name="products[]" id="product" onchange="return ShowProductSection();">
                @foreach($products as $product )
                    <option data-product-type="{{$product->type}}" value="{{$product->product_id}}">{{$product->trans->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <!-- end product div -->

    <!-- div plus button -->
    <div class="form-group col-sm-2">
        <label for="" class="col-2 col-form-label"></label>
        <div class="col-10">
            <button type="button" name="remove_product_form"
                    class="btn btn-danger btn-md remove_product_form">-
            </button>
        </div>
    </div>
    <!-- end div plus button  -->

    <!-- productNormalWrapper div -->
    <div class="ProductNormalWrapper hidden">
        <!-- productNormal div  -->
        <div class="productNormal col-sm-12">

            <!-- price div  -->
            <div class="form-group col-sm-4">
                <label for="price" class="col-2 col-form-label ">Price</label>
                <div class="col-10">
                    <input class="form-control" type="text" id="price"
                           name="price[]"
                           placeholder="price">
                </div>
            </div>
            <!-- end price div -->

            <!-- serial div  -->
            <div class="form-group col-sm-4">
                <label for="serial" class="col-2 col-form-label ">Serial</label>
                <div class="col-10">
                    <input class="form-control" type="text" id="serial"
                           name="serial[]"
                           placeholder="serial">
                </div>
            </div>
            <!-- end serial div -->

            <!-- model number div -->
            <div class="form-group col-sm-4">
                <label for="model_number" class="col-2 col-form-label ">Model Number</label>
                <div class="col-10">
                    <input class="form-control" type="text" id="model_number"
                           name="model_number[]"
                           placeholder="model number">
                </div>
            </div>
            <!-- end model number div -->

            <!-- barcode div -->
            <div class="form-group col-sm-4">
                <label for="barcode" class="col-2 col-form-label ">Barcode</label>
                <div class="col-10">
                    <input class="form-control" type="text" id="barcode"
                           name="barcode[]"
                           placeholder="barcode">
                </div>
            </div>
            <!-- end barcode div -->

            <!-- discount div -->
            <div class="form-group col-sm-4">
                <label for="discount" class="col-2 col-form-label ">Discount</label>
                <div class="col-10">
                    <input class="form-control" type="text" id="discount"
                           name="discount[]"
                           placeholder="discount">
                </div>
            </div>
            <!-- end discount div -->

            <!-- stock div -->
            <div class="form-group col-sm-4">
                <label for="stock" class="col-2 col-form-label ">Stock</label>
                <div class="col-10">
                    <input class="form-control" type="text" id="stock"
                           name="stock[]"
                           placeholder="stock">
                </div>
            </div>
            <!-- end stock div -->

            <!-- discount type div -->
            <div class="form-group col-sm-4">
                <label for="discount_type" class="col-2 col-form-label ">Discount Type</label>
                <div class="col-10">
                    <input class="form-control" type="text" id="discount_type"
                           name="discount_type[]"
                           placeholder="discount type">
                </div>
            </div>
            <!-- end discount type div -->

            <!-- amount div -->
            <div class="form-group col-sm-4">
                <label for="amount" class="col-2 col-form-label ">Amount</label>
                <div class="col-10">
                    <input class="form-control" type="text" id="amount"
                           name="amount[]"
                           placeholder="20">
                </div>
            </div>
            <!-- end amount div -->

            <!-- cost div -->
            <div class="form-group col-sm-4">
                <label for="cost" class="col-2 col-form-label ">cost</label>
                <div class="col-10">
                    <input class="form-control" type="text" id="cost"
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
    <div class="ProductOptionWrapper hidden">
        <!-- ProductOption div -->
        <div class="productOption col-sm-12">

            <!-- addOptionWrapper div row -->
            <div class="addOptionWrapper2 row">
                <!-- addOption div -->
                <div class="addOption col-sm-12">

                    <!-- options div -->
                    <div class="form-group col-sm-4">
                        <label for="options" class="col-2 col-form-label">Options</label>
                        <div class="col-10">
                            <select class="form-control dynamic" name="options[]" id="options"  data-url="{{route('admin.boughts.optionDependentFetch')}}">
                                @foreach($options as $option)
                                    <option value="{{$option->id}}">{{$option->trans->option}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- end options div -->

                    <!--  option values div -->
                    <div class="form-group col-sm-3">
                        <label for="option_values" class="col-2 col-form-label">Option Values</label>
                        <div class="col-10">
                            <select class="selectpicker" name="option_values" id="option_values" multiple  data-selected-text-format="count > 3">
                            </select>
                        </div>
                    </div>
                    <!-- end option values div -->

                    <!-- price div  -->
                    <div class="form-group col-sm-3" >
                        <label for="price" class="col-2 col-form-label">Price</label>
                        <div class="col-10">
                            <input class="form-control" type="text" id="price"
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
                                    class="btn btn-primary btn-md add_option_section2">+
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
                    <input class="form-control" type="text" id="serial"
                           name="serial[]"
                           placeholder="serial">
                </div>
            </div>
            <!-- end serial div -->

            <!-- model number div  -->
            <div class="form-group col-sm-4">
                <label for="model_number" class="col-2 col-form-label ">Model Number</label>
                <div class="col-10">
                    <input class="form-control" type="text" id="model_number"
                           name="model_number[]"
                           placeholder="model number">
                </div>
            </div>
            <!-- end model number div -->

            <!-- barcode div -->
            <div class="form-group col-sm-4">
                <label for="barcode" class="col-2 col-form-label ">Barcode</label>
                <div class="col-10">
                    <input class="form-control" type="text" id="barcode"
                           name="barcode[]"
                           placeholder="barcode">
                </div>
            </div>
            <!-- end barcode div -->

            <!-- discount div -->
            <div class="form-group col-sm-4">
                <label for="discount" class="col-2 col-form-label ">Discount</label>
                <div class="col-10">
                    <input class="form-control" type="text" id="discount"
                           name="discount[]"
                           placeholder="discount">
                </div>
            </div>
            <!-- end discount div -->

            <!-- stock div -->
            <div class="form-group col-sm-4">
                <label for="stock" class="col-2 col-form-label ">Stock</label>
                <div class="col-10">
                    <input class="form-control" type="text" id="stock"
                           name="stock[]"
                           placeholder="stock">
                </div>
            </div>
            <!-- end stock div -->

            <!-- amount div -->
            <div class="form-group col-sm-4">
                <label for="amount" class="col-2 col-form-label ">Amount</label>
                <div class="col-10">
                    <input class="form-control" type="text" id="amount"
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
