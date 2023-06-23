@extends('master')

@section('pageTitle','Reset Password')

@section('content')

<!-- Logo -->
<div class="app-brand justify-content-center">
    <span class="app-brand-text  demo text-body fw-bolder">Reset Password</span>
</div>
<!-- /Logo -->
<p class="mb-4">Please type your new password to reset.</p>

@if(session()->has('notice'))
<p class="mb-2">{{ session()->get('notice')}}</p>
@elseif(session()->has('error'))
<p class="mb-2 text-danger">{{ session()->get('error')}}</p>
@endif

<form id="formAuthentication" class="mb-3" action="{{ route('password.update.next') }}" method="POST">
    @csrf

    <input type="hidden" name="update" value="1">

    <div class="mb-3 form-password-toggle">
        <div class="d-flex justify-content-between">
            <label class="form-label" for="password">Password</label> @error('password') <span class="small text-danger">{{$message}}</span> @enderror
        </div>
        <div class="input-group input-group-merge">
            <input type="password" id="password" class="form-control" name="password" placeholder="Enter your Password" aria-describedby="password" />
            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
        </div>
    </div>

    <div class="mb-3 form-password-toggle">
        <div class="d-flex justify-content-between">
            <label class="form-label" for="confirm_password">Confirm Password</label> @error('confirm_password') <span class="small text-danger">{{$message}}</span> @enderror
        </div>
        <div class="input-group input-group-merge">
            <input type="password" id="confirm_password" class="form-control" name="confirm_password" placeholder="Confirm Password" aria-describedby="password" />
            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
        </div>
    </div>


    <button class="btn btn-primary d-grid w-100">Update</button>
</form>

<p class="text-center">
    <a href="{{ route('login') }}">
        <span> <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i> Back to Login</span>
    </a>
</p>

@endsection