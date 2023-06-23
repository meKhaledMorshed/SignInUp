@extends('master')

@section('pageTitle','Forgot Password')

@section('content')

<!-- Logo -->
<div class="app-brand justify-content-center">
    <a href="index.html" class="app-brand-link gap-2">

        <span class="app-brand-text  demo text-body fw-bolder">Reset Password</span>
    </a>
</div>
<!-- /Logo -->
<h4 class="mb-2">Forgot Password? 🔒</h4>
<p class="mb-4">Enter your email and we'll send you a code to reset your password</p>

@if(session()->has('notice'))
<p class="mb-2">{{ session()->get('notice')}}</p>
@elseif(session()->has('error'))
<p class="mb-2 text-danger">{{ session()->get('error')}}</p>
@endif

<form id="formAuthentication" class="mb-3" action="{{ route('password.check_email') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>@error('email') <span class="small text-danger">{{$message}}</span> @enderror
        <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" />
    </div>


    <button class="btn btn-primary d-grid w-100">Send Code</button>
</form>

<p class="text-center">
    <a href="auth-login-basic.html">
        <span> <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i> Back to Login</span>
    </a>
</p>

@endsection