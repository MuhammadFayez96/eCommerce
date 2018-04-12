@extends('admin.master')

@section('content-header')
  <section class="content-header">
      <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><h4>Options</h4></li>
              <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{url('options')}}">Options</a></li>
              <li class="breadcrumb-item"><a href="{{url('options/get-create')}}">Add Options</a></li>
          </ol>
      </nav>
  </section>
@endsection

@section('content')

  <section class="content">
      <div class="panel panel-primary">
          <!-- Default panel contents -->
          <div class="panel-heading" style="font-size: large">Options</div>

          <form action="{{route('admin.options.createNewOption')}}" class="add-form" enctype="multipart/form-data"
                method="post"
                onsubmit="return false;">
              {!! csrf_field() !!}
              <div class="modal-body">
                  <div class="row">
                    <div class="form-group col-sm-12">
                      <label class="col-2 col-form-label ">Options</label>
                    </div>
                      <div class="form-group col-sm-5">
                          <div class="col-10">
                              <input class="form-control required" type="text"  name="option_name_en"
                                     placeholder="option in english">
                          </div>
                      </div>

                      <div class="form-group col-sm-5">
                          <div class="col-10">
                              <input class="form-control required" type="text" name="option_name_ar"
                                     placeholder="القيمه باللغه العربيه ">
                          </div>
                      </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-sm-12">
                      <label class="col-2 col-form-label ">Values</label>
                    </div>
                  </div>

                  <div class="row addValueWrapper">
                    <div class="addValue">
                      <div class="form-group col-sm-5">
                            <input class="form-control " type="text"
                                     name="option_value_en[]"
                                     placeholder="value in english">
                      </div>
                      <div class="form-group col-sm-5">
                              <input class="form-control" type="text"
                                     name="option_value_ar[]"
                                     placeholder="القيمه باللغه العربيه">
                      </div>
                      <div class="form-group col-sm-2">
                              <button type="button"  name="add-value"
                                      class="btn btn-primary btn-md add-value">+
                              </button>
                      </div>
                    </div>
                  </div>

                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn-submit btn btn-primary btn-sm btn-flat">
                          Save <span class="glyphicon glyphicon-save"> </span>
                      </button>
                  </div>
              </div>
          </form>
      </div>
  </section>
@endsection
