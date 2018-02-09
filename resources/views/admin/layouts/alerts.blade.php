@if(isset($errors) && count($errors) > 0)
    <div class="alert alert-danger alert-dismissable">
        <button class="close" data-dismiss="alert" area-hidden="true">&times;</button>
        <ul>
            @foreach($errors->all() as $error)
                <li>
                    {{$error}}
                </li>
            @endforeach
        </ul>
    </div>
@endif
@if(session()->has('info'))
    <div class="alert alert-info alert-dismissable">
        <button class="close" data-dismiss="alert" area-hidden="true">&times;</button>
        {{session()->pull('info')}}
    </div>
@endif
@if(session()->has('success'))
    <div class="alert alert-success alert-dismissable">
        <button class="close" data-dismiss="alert" area-hidden="true">&times;</button>
        {{session()->pull('success')}}
    </div>
@endif
@if(session()->has('error'))
    <div class="alert alert-danger alert-dismissable">
        <button class="close" data-dismiss="alert" area-hidden="true">&times;</button>
        {{ session()->pull('error')}}
    </div>
@endif
@if(session()->has('warning'))
    <div class="alert alert-warning alert-dismissable">
        <button class="close" data-dismiss="alert" area-hidden="true">&times;</button>
        {{session()->pull('warning')}}
    </div>
@endif
