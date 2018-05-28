@extends('admin.master')

@section('content-header')
    <section class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><h4>Categories</h4></li>
                <li class="breadcrumb-item"><a href="{{  route('admin.home')  }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{  route('admin.categories.getIndex')  }}">Categories</a></li>
            </ol>
        </nav>
    </section>
@endsection

@section('content')
    <section class="content">

        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading" style="font-size: large">Categories</div>

            <form action="{{   route('admin.categories.getIndex') }}" onsubmit="return false;">

                {{ csrf_field() }}

                <div class="panel-body">
                    <a href="{{  route('admin.categories.getCreateNewCategory')}}" class="btn btn-primary btn-md">
                        <li class="fa fa-plus"> Add Category</li>
                    </a>
                </div>

                <div class="table-responsive">
                    <!-- Table -->
                    <table class="table">
                        <thead>
                        <tr style="color: black; font-size: medium;">
                            <th class="text-center">category</th>
                            <th class="text-center">type</th>
                            <th class="text-center">operations</th>
                        </tr>
                        </thead>
                        <tbody class="table-hover">
                        @foreach($categories as $category)
                            <tr>
                                <td class="text-center">{{$category->category_translated->category}}</td>
                                <td class="text-center">
                                    {{$category->isMain() ? 'Main' : 'Sub from :'}}

                                    @if(!$category->isMain())
                                        <a href="{{  route('admin.categories.getUpdateCategory', [ 'id' => $category->main->id])  }}" style="color: red;">
                                            {{ $category->main->translate()->category }}
                                        </a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{  route('admin.categories.getUpdateCategory', [ 'id' => $category->id])  }}" class="btn btn-warning btn-sm">
                                        <li class="fa fa-pencil"> Edit</li>
                                    </a>

                                    <input type="hidden" name="_method" value="delete"/>

                                    <a class="btn btn-danger btn-sm" title="Delete" data-toggle="modal"
                                       href="#delete"
                                       data-id="{{$category->id}}"
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
    @include('admin.pages.categories.modals.delete-category')
@endsection
