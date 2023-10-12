@extends('endUser.layouts.master')


@section('title', 'tsouq Sign Up')


@section('page title', 'Sign Up & Start Shopping')

@section('page', 'Sign up')

@section('content')
    @include('endUser.layouts.header')

    <div class="row col-12 pb-3">
        <div class="col-12 pb-1 d-flex justify-content-center">
            <form id="formAuthentication" class="mb-3 col-5" action="{{ route('user-register.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="user-name" class="form-label">User Name</label>
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <input type="text" class="form-control @error('name') border-danger @enderror" id="user-name" value="{{old('name')}}"
                        name="name" placeholder="Enter your User Name" autofocus />
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    @error('email')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <input type="text" class="form-control @error('email') border-danger @enderror" id="email" value="{{old('email')}}"
                        name="email" placeholder="Enter your email" autofocus />
                </div>
                <div class="mb-3 form-password-toggle">
                    <label class="form-label" for="password">Password</label>
                    @error('password')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <div class="input-group input-group-merge">
                        <input type="password" id="password"
                            class="form-control @error('password') border-danger @enderror" name="password"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            aria-describedby="password" />
                        <span class="input-group-text cursor-pointer @error('email') border-danger @enderror"><i
                                class="bx bx-hide @error('email') border-danger text-danger @enderror"></i></span>
                    </div>
                </div>
                <div class="mb-3 form-password-toggle">
                    <label class="form-label" for="password">Password Confirm</label>
                    @error('password')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <div class="input-group input-group-merge">
                        <input type="password" id="password"
                            class="form-control @error('password') border-danger @enderror" name="password_confirmation"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            aria-describedby="password" />
                        <span class="input-group-text cursor-pointer @error('email') border-danger @enderror"><i
                                class="bx bx-hide @error('email') border-danger text-danger @enderror"></i></span>
                    </div>
                </div>
                    <div class="mb-3">
                        <button class="btn btn-primary d-grid w-100" type="submit">Sign Up</button>
                    </div>
            </form>
        </div>
        <!-- Shop Product End -->
    </div>
@endsection
