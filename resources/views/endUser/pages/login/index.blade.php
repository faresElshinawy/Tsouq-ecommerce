@extends('endUser.layouts.master')


@section('title','tsouq Sign')


@section('page title','Sign IN & Start Shopping')

@section('page','Sign')

@section('content')
@include('endUser.layouts.header')


<div class="row col-12 pb-3">
    <div class="col-12 pb-1 d-flex justify-content-center">
        <form id="formAuthentication" class="mb-3 col-5" action="{{ route('user-login.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                @error('email')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <input type="text" class="form-control @error('email') border-danger @enderror" id="email" name="email"
                    placeholder="Enter your email" autofocus />
            </div>
            <div class="mb-3 form-password-toggle">
                        <label class="form-label" for="password">Password</label>
                        @error('password')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                <div class="input-group input-group-merge">
                    <input type="password" id="password" class="form-control @error('password') border-danger @enderror" name="password"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                        aria-describedby="password" />
                    <span class="input-group-text cursor-pointer @error('email') border-danger @enderror"><i class="bx bx-hide @error('email') border-danger text-danger @enderror"></i></span>
                </div>
            </div>
            <div class="mb-3 ml-2 d-flex justify-content-between">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember-me"
                        name="remember" />
                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                </div>
                <a href="{{ route('password.request') }}">
                    <small>Forgot Password?</small>
                </a>
            </div>
            <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">Sign In</button>
            </div>
            <div class="mb-3">
                <a class="btn btn-primary d-grid w-100" href="{{route('social-login.google')}}">Sign In With Google</a>
            </div>
        </form>
    </div>
</div>
@endsection


