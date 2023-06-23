@extends('master')

@section('pageTitle','Login')

@section('content')

<!-- Logo -->
<div class="app-brand justify-content-center">
    <span class="app-brand-text  demo text-body fw-bolder">Login</span>
</div>
<!-- /Logo -->
@if(session()->has('notice'))
<p class="mb-2">{{ session()->get('notice')}}</p>
@elseif(session()->has('error'))
<p class="mb-2 text-danger">{{ session()->get('error')}}</p>
@endif

<form id="formAuthentication" class="mb-3" action="{{ route('login.request') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="email" class="form-label">Email</label> @error('email') <span class="small text-danger">{{$message}}</span> @enderror
        <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" autofocus />
    </div>
    <div class="mb-3 form-password-toggle">
        <div class="d-flex justify-content-between">
            <label class="form-label" for="password">Password</label> @error('password') <span class="small text-danger">{{$message}}</span> @enderror
            <a href="{{ route('password.forgot') }}">
                <small>Forgot Password?</small>
            </a>
        </div>
        <div class="input-group input-group-merge">
            <input type="password" id="password" class="form-control" name="password" placeholder="Enter your Password" aria-describedby="password" />
            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
        </div>
    </div>
    <div class="mb-3">
        <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
    </div>
</form>

<p class="text-center">
    <span>New on our platform?</span>
    <a href="{{ route('signup') }}">
        <span>Create an account</span>
    </a>
</p>

@endsection