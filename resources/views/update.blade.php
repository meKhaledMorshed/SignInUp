@extends('master')

@section('pageTitle','Update')

@section('content')

<!-- Logo -->
<div class="app-brand justify-content-center">
    <a href="{{route('landing')}}" class="app-brand-link gap-2">

        <span class="app-brand-text  demo text-body fw-bolder">Update</span>
    </a>
</div>
<!-- /Logo -->

@if(session()->has('error'))
<span class="small mb-2 text-danger">{{ session()->get('error')}}</span>
@endif

<form id="signup" class="mb-3" action="{{ route('update.request' ) }}" method="POST">
    @csrf
    <input type="hidden" name="uid" value="{{ $user->id }}" />
    <div class="mb-3">
        <label for="name" class="form-label">Name </label> @error('name') <span class="text-danger mx-2 small">{{$message }}</span> @enderror
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your Name" value="{{ $user->name }}" autofocus />
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label> @error('email') <span class="text-danger mx-2 small">{{$message}}</span> @enderror
        <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" value="{{ $user->email }}" />
    </div>

    <button class="btn btn-primary d-grid w-100 mt-3">Update</button>
</form>

<p class="text-center">
    <a href="{{route('landing')}}">Back </a>
</p>

@endsection