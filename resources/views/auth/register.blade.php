@extends('layouts.app')
@section('content')
<div class="row">
    <form class="col-8 offset-2 o-login" method="POST" action="{{ route('login') }}">
        @csrf

        <div class="row m-login-header">
            <h2>
                Register
            </h2>
        </div>
        <div class="row m-form-group">
            <div class="col-4">
                <label for="name">Name</label>
            </div>
            <div class="col-5">
                <input type="text" name="name" value="{{ old('name') }}" class="@error('name') is-invalid @enderror" required autofocus>
            </div>
        </div>
        <div class="row m-form-group">
            <div class="col-4">
                <label for="email">Email</label>
            </div>
            <div class="col-5">
                <input type="email" name="email" value="{{ old('email') }}" class="@error('email') is-invalid @enderror" required autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
        </div>
        <div class="row m-form-group">
            <div class="col-4">
                <label for="password">{{ __('Password') }}</label>
            </div>

            <div class="col-5">
                <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row m-form-group">
            <div class="col-4">
                <label for="password-confirm">{{ __('Confirm Password') }}</label>
            </div>

            <div class="col-5">
                <input id="password-confirm" type="password" class="" name="password_confirmation" required autocomplete="new-password">
            </div>
        </div>

        <div class="row m-form-group">
            <div class="col-5 offset-4">
                <button type="submit">Register</button>
            </div>
        </div>
    </form>
</div>
@endsection

