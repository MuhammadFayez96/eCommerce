
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

@section('scripts')
<script>

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
