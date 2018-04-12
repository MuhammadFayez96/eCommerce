@extends('admin.master')

@section('content-header')
    <section class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><h4>Options</h4></li>
                <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('options')}}">Options</a></li>
                <li class="breadcrumb-item"><a href="{{url('options/get-update/'.$option->id)}}">Edit Options</a></li>
            </ol>
        </nav>
    </section>
@endsection

@section('content')

    <section class="content">
        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading" style="font-size: large">Options</div>

            <form action="{{ route('admin.options.updateOption', ['id' => $option->id]) }}" onsubmit="return false;" method="post" >

                {!! csrf_field() !!}

                <div class="panel-body">
                    <div class="row">
                      <div class="form-group col-sm-12">
                        <label class="col-2 col-form-label ">Options</label>
                      </div>

                        <div class="form-group col-sm-6">
                            <div class="col-10">
                                <input class="form-control option_name_en" type="text"  name="option_name_en"
                                       placeholder="option in english" value="{{$option->option_en_translated->option}}">
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <div class="col-10">
                                <input class="form-control option_name_ar" type="text"  name="option_name_ar"
                                       placeholder="الاختيار باللغه العربيه" value="{{$option->option_ar_translated->option}}">
                            </div>
                        </div>
                    </div>
                    <div class="row editValuesWrapper">
                      <div class="editValue">
                        <div class="form-group col-sm-10">
                          <div class="col-10">
                            <label class="col-2 col-form-label ">Values</label>
                          </div>
                        </div>

                        <div class="form-group col-sm-2">
                          <div class="col-10">
                            <button type="button"  name="add-values"
                                      class="btn btn-primary btn-md add-values">+
                            </button>
                          </div>
                        </div>
                      </div>


                      @foreach($option_values as $option_value)
                        <div class="editValue">
                          <div class="form-group col-sm-5">
                              <input class="form-control option_value_en" type="text" name="option_value_en[]"
                                   placeholder="value in english" value="{{$option_value->en->value}}" data-value-id="{{$option_value->en->option_value_id}}">
                          </div>

                          <div class="form-group col-sm-5">
                              <input class="form-control option_value_ar" type="text" name="option_value_ar[]"
                                     placeholder="القيمة باللغة العربيه" value="{{$option_value->ar->value}}" data-value-id="{{$option_value->ar->option_value_id}}">
                          </div>

                          <div class="form-group col-sm-2">
                              <button type="button" name="remove"
                                class="btn btn-danger btn-md value-remove"
                                data-url="{{route('admin.options.deleteOptionValue', ['id' => $option_value->id])}}">X</button>
                          </div>
                        </div>
                      @endforeach
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn-update-submit
                          btn btn-primary btn-md btn-flat">
                            Edit <span class="glyphicon glyphicon-save"> </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
