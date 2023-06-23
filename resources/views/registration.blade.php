@extends('master')

@section('pageTitle','Register')

@section('content')

<!-- Logo -->
<div class="app-brand justify-content-center">
    <a href="{{route('landing')}}" class="app-brand-link gap-2">

        <span class="app-brand-text  demo text-body fw-bolder">Register</span>
    </a>
</div>
<!-- /Logo -->
<h4 class="mb-2">Welcome to SignInUp! 👋</h4>
<p class="mb-2">Please fillup below form to create account.</p>

@if(session()->has('error'))
<span class="small mb-2 text-danger">{{ session()->get('error')}}</span>
@endif

<form id="signup" class="mb-3" action="{{ route('signup.request' ) }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Name </label> @error('name') <span class="text-danger mx-2 small">{{$message }}</span> @enderror
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your Name" value="{{ old('name') }}" autofocus />
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label> @error('email') <span class="text-danger mx-2 small">{{$message}}</span> @enderror
        <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" />
    </div>
    <div class="mb-3 form-password-toggle">
        <label class="form-label" for="password">Password</label> @error('password') <span class="text-danger mx-2 small">{{$message}}</span> @enderror
        <div class="input-group input-group-merge">
            <input type="password" id="password" class="form-control" name="password" placeholder="Password" value="{{ old('password')}}" />
            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
        </div>
    </div>

    <div class="mb-1">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="terms" name="terms" />
            <label class="form-check-label" for="terms"> I agree to privacy policy & terms. </label>
        </div>
    </div>
    @error('terms') <span class="text-danger"> {{$message}}</span> @enderror
    <button class="btn btn-primary d-grid w-100 mt-3">Sign up</button>
</form>

<p class="text-center">
    <span>Already have an account?</span>
    <a href="auth-login-basic.html">
        <span>Sign in instead</span>
    </a>
</p>

@endsection