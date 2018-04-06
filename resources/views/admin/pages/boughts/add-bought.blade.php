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

            <form action="{{ url('boughts/create') }}" onsubmit="return false;" method="post"
                  class="add-form">

                {!! csrf_field() !!}

                <div class="panel-body">

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="role" class="col-2 col-form-label">Users</label>
                            <div class="col-10">
                                <select class="form-control" name="role_id" id="role">
                                    <option value="">Choose user:</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}">{{$role->role}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="bought_type" class="col-2 col-form-label">Bought Type</label>
                            <div class="col-10">
                                <label class="radio-inline"><input type="radio" name="typeRadio" id="kashr" onchange="return kash();">Kash</label>
                                <label class="radio-inline"><input type="radio" name="typeRadio" id="ba2yr" onchange="return ba2y();">Ba2y</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="total_price" class="col-2 col-form-label ">Total Price</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="total_price" name="total_price"
                                       placeholder="20">
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="total_amount" class="col-2 col-form-label">Total Amount</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="total_amount"
                                       name="total_amount"
                                       placeholder="20">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="paid" class="col-2 col-form-label ">Paid</label>
                            <div class="col-10">
                                <input class="form-control required" type="text" id="paid" name="paid"
                                       placeholder="20">
                            </div>
                        </div>

                        <div class="form-group col-sm-6" >
                            <label for="remain" class="col-2 col-form-label">Remain</label>
                            <div class="col-10">
                                <input class="form-control required remain" type="text" id="remain"
                                       name="remain"
                                       placeholder="20">
                            </div>
                        </div>
                    </div>

                    <table class="table table-bordered" id="form">
                        <tr>
                            <td>
                                <div class="form-group col-sm-10">
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label for="product" class="col-2 col-form-label">Products</label>
                                            <div class="col-10">
                                                <select class="form-control" name="product_id" id="product">
                                                    <option value="">Choose product:</option>
                                                    @foreach($products as $product )
                                                        <option value="{{$product->product_id}}">{{$product->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="product_type" class="col-2 col-form-label">Product Type:</label>
                                            <div class="col-10">
                                                <label class="radio-inline"><input type="radio" name="optradio[]">Normal</label>
                                                <label class="radio-inline"><input type="radio" name="optradio[]">Option</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="total">
                                        <div class="form-group col-sm-6">
                                            <label for="amount" class="col-2 col-form-label ">Amount</label>
                                            <div class="col-10">
                                                <input class="form-control" type="text" id="amount"
                                                       name="amount[]"
                                                       placeholder="20">
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label for="cost" class="col-2 col-form-label">Cost</label>
                                            <div class="col-10">
                                                <input class="form-control" type="text" id="cost"
                                                       name="cost[]"
                                                       placeholder="20">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group col-sm-2">
                                    <div class="col-10">
                                        <button type="button" name="add"
                                                class="btn btn-primary btn-md add_form">+
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>

                    <div class="modal-footer">
                        <button type="submit" class="btn-submit btn btn-primary btn-md btn-flat">
                            Save <span class="glyphicon glyphicon-save"> </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
