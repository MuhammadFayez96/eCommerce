@extends('admin.master')

@section('content-header')
    <section class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><h4>Products</h4></li>
                <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('products')}}">Products</a></li>
            </ol>
        </nav>
    </section>
@endsection

@section('content')
    <section class="content">

        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading" style="font-size: large">Products</div>
            <form action="{{ url('admin/products/') }}" onsubmit="return false;">

                {{ csrf_field() }}

                <div class="panel-body">
                    <a href="{{url('products/get-create')}}" class="btn btn-primary btn-sm">
                        <li class="fa fa-plus"> Add product</li>
                    </a>
                </div>

                <div class="table-responsive">
                    <!-- Table -->
                    <table class="table">
                        <thead>
                        <tr style="color: black; font-size: medium;">
                            <th class="text-center">Name</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Notes</th>
                            <th class="text-center">Operations</th>
                        </tr>
                        </thead>
                        <tbody class="table-hover">
                        @foreach($products as $product)
                            <tr>
                                <td class="text-center">{{$product->product_translated->name}}</td>
                                <td class="text-center">{{$product->type}}</td>
                                <td class="text-center">{{$product->product_translated->description}}</td>
                                <td class="text-center">{{$product->product_translated->notes}}</td>
                                <td class="text-center">
                                    <a href="{{url('products/get-update/'.$product->id)}}"
                                       class="btn btn-warning btn-sm">
                                        <li class="fa fa-pencil"> Edit</li>
                                    </a>

                                    <a class="btn btn-danger btn-sm" title="Delete" data-toggle="modal"
                                       href="#delete"
                                       data-id="{{$product->id}}"
                                       data-token="{{csrf_token()}}">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
            </form>
        </div>
    </section>

@endsection

@section('modals')
    @include('admin.pages.products.modals.delete-product')
@endsection
