
<!-- addOption div -->
<div class="addOption col-sm-12">

    <!-- options div -->
    <div class="form-group col-sm-4">
        <label for="options" class="col-2 col-form-label">options</label>
        <div class="col-10">
            <select class="form-control dynamic" name="options[]" class="options"  data-url="{{route('admin.boughts.optionDependentFetch')}}">
                @foreach($options as $option)
                    <option value="{{$option->id}}">{{$option->trans->option}}</option>
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

    <!-- remove button for new option section div  -->
    <div class="form-group col-sm-2">
        <label for="" class="col-2 col-form-label"></label>
        <div class="col-10">
            <button type="button" name="remove_option_section"
                    class="btn btn-danger btn-md remove_option_section">-
            </button>
        </div>
    </div>
    <!-- end remove button div -->
</div>
<!-- end class addOption div  -->
