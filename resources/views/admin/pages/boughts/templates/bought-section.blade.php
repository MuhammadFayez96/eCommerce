<div class="bought col-sm-12 row">
    <div class="form-group col-sm-4">
        <label for="product" class="col-2 col-form-label">Products</label>
        <div class="col-10">
            <select class="form-control" name="product_id" id="product" onchange="return showComponent();">
                @foreach($products as $product )
                    <option data-product-type="{{$product->type}}" value="{{$product->product_id}}">{{$product->trans->name}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group col-sm-2">
        <label for="" class="col-2 col-form-label"></label>
        <div class="col-10">
            <button type="button" name="add_product_form"
                    class="btn btn-primary btn-md">+
            </button>
        </div>
    </div>

    <div class="productNormalWrapper hidden">
        <div class="productNormal col-sm-12">
            <div class="form-group col-sm-6">
                <label for="price" class="col-2 col-form-label ">Price</label>
                <div class="col-10">
                    <input class="form-control" type="text" id="price"
                           name="price[]"
                           placeholder="price">
                </div>
            </div>

            <div class="form-group col-sm-6">
                <label for="serial" class="col-2 col-form-label ">Serial</label>
                <div class="col-10">
                    <input class="form-control" type="text" id="serial"
                           name="serial[]"
                           placeholder="serial">
                </div>
            </div>

            <div class="form-group col-sm-6">
                <label for="model_number" class="col-2 col-form-label ">Model Number</label>
                <div class="col-10">
                    <input class="form-control" type="text" id="model_number"
                           name="model_number[]"
                           placeholder="model number">
                </div>
            </div>

            <div class="form-group col-sm-6">
                <label for="barcode" class="col-2 col-form-label ">Barcode</label>
                <div class="col-10">
                    <input class="form-control" type="text" id="barcode"
                           name="barcode[]"
                           placeholder="barcode">
                </div>
            </div>

            <div class="form-group col-sm-6">
                <label for="discount" class="col-2 col-form-label ">Discount</label>
                <div class="col-10">
                    <input class="form-control" type="text" id="discount"
                           name="discount[]"
                           placeholder="discount">
                </div>
            </div>

            <div class="form-group col-sm-6">
                <label for="stock" class="col-2 col-form-label ">Stock</label>
                <div class="col-10">
                    <input class="form-control" type="text" id="stock"
                           name="stock[]"
                           placeholder="stock">
                </div>
            </div>

            <div class="form-group col-sm-6">
                <label for="discount_type" class="col-2 col-form-label ">Discount Type</label>
                <div class="col-10">
                    <input class="form-control" type="text" id="discount_type"
                           name="discount_type[]"
                           placeholder="discount type">
                </div>
            </div>

            <div class="form-group col-sm-6">
                <label for="amount" class="col-2 col-form-label ">Amount</label>
                <div class="col-10">
                    <input class="form-control" type="text" id="amount"
                           name="amount[]"
                           placeholder="20">
                </div>
            </div>


            <div class="form-group col-sm-6">
                <label for="cost" class="col-2 col-form-label ">cost</label>
                <div class="col-10">
                    <input class="form-control" type="text" id="cost"
                           name="cost[]"
                           placeholder="cost">
                </div>
            </div>
        </div>
    </div>

    <div class="ProductOptionWrapper hidden">
        <div class="productOption col-sm-12">

            <div class="addOptionWrapper row">
                <div class="addOption">
                    <div class="form-group col-sm-4">
                        <label for="option" class="col-2 col-form-label">Options</label>
                        <div class="col-10">
                            <select class="form-control" name="options[]" id="option">
                                    <option value=""></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="option_values" class="col-2 col-form-label">Option Values</label>
                        <div class="col-10">
                            <select class="selectpicker" name="option_values[]" multiple data-selected-text-format="count > 3">
                              <option value=""></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-sm-3" >
                        <label for="price" class="col-2 col-form-label">Price</label>
                        <div class="col-10">
                            <input class="form-control" type="text" id="price"
                                   name="price[]"
                                   placeholder="price">
                        </div>
                    </div>

                    <div class="form-group col-sm-2">
                        <label for="" class="col-2 col-form-label"></label>
                        <div class="col-10">
                            <button type="button" name="add_fields"
                                    class="btn btn-primary btn-md add_fields">+
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="form-group col-sm-4">
                <label for="serial" class="col-2 col-form-label ">Serial</label>
                <div class="col-10">
                    <input class="form-control" type="text" id="serial"
                           name="serial[]"
                           placeholder="serial">
                </div>
            </div>

            <div class="form-group col-sm-4">
                <label for="model_number" class="col-2 col-form-label ">Model Number</label>
                <div class="col-10">
                    <input class="form-control" type="text" id="model_number"
                           name="model_number[]"
                           placeholder="model number">
                </div>
            </div>

            <div class="form-group col-sm-4">
                <label for="barcode" class="col-2 col-form-label ">Barcode</label>
                <div class="col-10">
                    <input class="form-control" type="text" id="barcode"
                           name="barcode[]"
                           placeholder="barcode">
                </div>
            </div>

            <div class="form-group col-sm-4">
                <label for="discount" class="col-2 col-form-label ">Discount</label>
                <div class="col-10">
                    <input class="form-control" type="text" id="discount"
                           name="discount[]"
                           placeholder="discount">
                </div>
            </div>

            <div class="form-group col-sm-4">
                <label for="stock" class="col-2 col-form-label ">Stock</label>
                <div class="col-10">
                    <input class="form-control" type="text" id="stock"
                           name="stock[]"
                           placeholder="stock">
                </div>
            </div>

            <div class="form-group col-sm-4">
                <label for="amount" class="col-2 col-form-label ">Amount</label>
                <div class="col-10">
                    <input class="form-control" type="text" id="amount"
                           name="amount[]"
                           placeholder="amount">
                </div>
            </div>
        </div>
    </div>

</div>
