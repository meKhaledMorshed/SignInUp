@extends('master')

@section('pageTitle','Home')

@section('content')

<!-- Logo -->
<div class="app-brand justify-content-center">
    <a href="{{route('landing')}}" class="app-brand-link gap-2">
        <span class="app-brand-text  demo text-body fw-bolder">Home page</span>
    </a>
</div>
<!-- /Logo -->

@if(session()->has('notice'))
<p class="mb-2">{{ session()->get('notice')}}</p>
@endif

<div class="row mb-2">
    <div class="col-md-3">Name:</div>
    <div class="col-md-9">{{$data->name}}</div>
</div>

<div class="row mb-2">
    <div class="col-md-3">Email:</div>
    <div class="col-md-9">{{$data->email}}</div>
</div>

<div class="row mb-2">
    <div class="col-md-3">Two FA:</div>
    <div class="col-md-2">@if($data->twoFA==true) ON @else OFF @endif </div>
    <div class="col-md-7">
        <a href="{{route('reset.twofa')}}">
            @if($data->twoFA==false)
            <button class="p-1 btn btn-sm btn-primary">Turn on</button>
            @else
            <button class="p-1 btn btn-sm btn-danger">Turn OFF</button>
            @endif
        </a>
    </div>
</div>



<div class="row mt-3">
    <div class="col-md-3"> <a href="{{ route('update') }}"> <button class="p-1 btn btn-sm btn-primary">Update</button> </a> </div>
    <div class="col-md-5"><a href="{{ route('password.update') }}"> <button class="p-1 btn btn-sm btn-primary">Change Password</button> </a></div>
    <div class="col-md-3"><a href="{{ route('logout') }}"> <button class="p-1 btn btn-sm btn-danger">Logout</button> </a></div>
</div>







@endsection