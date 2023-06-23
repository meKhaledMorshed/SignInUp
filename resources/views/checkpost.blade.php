@extends('master')

@section('pageTitle','Checkpost')

@section('content')

<!-- Logo -->
<div class="app-brand justify-content-center">
    <span class="app-brand-text  demo text-body fw-bolder">Checkpost</span>
</div>
<!-- /Logo -->

@if(session()->has('notice'))
<p class="mb-2">{{ session()->get('notice')}}</p>
@else
<p class="mb-4">Please use your token.</p>
@endif

<form id="checkpostform" class="mb-3" action="{{ route('checkpost.next') }}" method="POST">
    @csrf
    <div class="mb-2">
        <label for="token" class="form-label">Token</label>

        @error('token') <span class="text-danger mx-2 small">{{$message}}</span> @enderror
        @if(session()->has('error'))
        <span class="small mb-2 text-danger">{{ session()->get('error')}}</span>
        @endif

        <input type="text" class="form-control" id="token" name="token" placeholder="Enter Token" autofocus />
    </div>


    <div class="mb-3">
        <button class="btn btn-primary d-grid w-100" type="submit">Submit</button>
    </div>
</form>

<p class="text-center">
    <span>Token not received?</span>
    <a href="#">
        <span>Send Again</span>
    </a>
</p>

@endsection