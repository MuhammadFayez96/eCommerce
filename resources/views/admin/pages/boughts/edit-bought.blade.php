@extends('admin.master')

@section('content-header')
    <section class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><h4>Boughts</h4></li>
                <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('boughts')}}">Boughts</a></li>
                <li class="breadcrumb-item"><a href="{{url('boughts/get-update')}}">Edit Boughts</a>
                </li>
            </ol>
        </nav>
    </section>
@endsection

@section('content')

    <section class="content">
        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading" style="font-size: large">Boughts</div>

            <form action="{{ url('boughts/post-update') }}" onsubmit="return false;" method="post"
                  class="update-form">

                {!! csrf_field() !!}

                <div class="panel-body">


                    <div class="modal-footer">
                        <button type="submit" class="btn-update-submit btn btn-warning btn-md btn-flat">
                            Edit <span class="glyphicon glyphicon-save"> </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
