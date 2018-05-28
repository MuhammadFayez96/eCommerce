@extends('admin.master')

@section('content-header')
  <section class="content-header">
      <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><h4>Options</h4></li>
              <li class="breadcrumb-item"><a href="{{  route('admin.home')  }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{  route('admin.options.getIndex')  }}">Options</a></li>
              <li class="breadcrumb-item"><a href="{{  route('admin.options.getCreateNewOption')  }}">Add Options</a></li>
          </ol>
      </nav>
  </section>
@endsection

@section('content')

  <!-- start content div  -->
  <section class="content">

      <!-- start panel-primary div  -->
      <div class="panel panel-primary">

          <!-- Default panel contents -->
          <div class="panel-heading" style="font-size: large">Options</div>

          <!-- start form submit  -->
          <form action="{{route('admin.options.createNewOption')}}" class="add-form" enctype="multipart/form-data"
                method="post"
                onsubmit="return false;">

              {!! csrf_field() !!}

              <!--  start modal-body div-->
              <div class="modal-body">

                  <!-- start option div row  -->
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
                  <!-- end of option div row -->

                  <!-- start values label div row -->
                  <div class="row">
                    <div class="form-group col-sm-12">
                      <label class="col-2 col-form-label ">Values</label>
                    </div>
                  </div>
                  <!-- end of values label div row  -->

                  <!-- start addValueWrapper div row -->
                  <div class="row addValueWrapper">
                    <!-- start addValue div  -->
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
                    <!-- end of addValue div  -->

                  </div>
                  <!-- end of addValueWrapper div row -->

                  <!-- start modal-footer div -->
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn-submit btn btn-primary btn-sm btn-flat">
                          Save <span class="glyphicon glyphicon-save"> </span>
                      </button>
                  </div>
                  <!-- end modal-footer div -->

              </div>
              <!-- end of modal-body div row  -->

          </form>
          <!-- end of form submited -->

      </div>
      <!-- end of panel-primary div row -->

  </section>
  <!-- end of section -->

@endsection
