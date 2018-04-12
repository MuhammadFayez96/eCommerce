
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
                <button type="button" name="remove_fields"
                        class="btn btn-danger btn-md remove_fields">-
                </button>
            </div>
        </div>
    </div>
