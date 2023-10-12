@extends('dashboard.layouts.master')


@section('content')
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">New User</h5>
            </div>
            <div class="card-body">
                <form action='{{ route('users.store') }}' method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Name</label>
                        <div class="col-sm-10">
                            <input type="text" value='{{ old('name') }}'
                                class="form-control  @error('name') border-danger @enderror" id="basic-default-name"
                                name="name" placeholder="Name">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Email</label>
                        <div class="col-sm-10">
                            <input type="email" value='{{ old('email') }}'
                                class="form-control  @error('email') border-danger @enderror" id="basic-default-name"
                                name="email" placeholder="Email">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Password</label>
                        <div class="col-sm-10">
                            <input type="password" value='{{ old('password') }}'
                                class="form-control  @error('password') border-danger @enderror" id="basic-default-name"
                                name="password" placeholder="Password">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Password Confirm</label>
                        <div class="col-sm-10">
                            <input type="password" value='{{ old('password') }}'
                                class="form-control  @error('password') border-danger @enderror" id="basic-default-name"
                                name="password_confirmation" placeholder="Password">
                        </div>
                    </div>


                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Image</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control @error('image') border-danger @enderror"
                                name="image">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Roles</label>
                        <div class="col-10">

                            @foreach ($roles as $role)

                                <div class="form-check mt-3 d-inline-block mx-1">
                                    <input class="form-check-input  @error('roles') border-danger @enderror" type="checkbox"
                                        value="{{ $role->name }}" name='roles[]' id="defaultCheck{{ $role->id }}"
                                    @if (old('roles'))
                                        @foreach (old('roles') as $role_opt)
                                            @if ($role_opt == $role->name)
                                                {{ 'checked' }}
                                            @endif
                                        @endforeach
                                    @endif
                            >
                            <label class="form-check-label" for="defaultCheck{{ $role->id }}"> {{ $role->name }}
                            </label>
                        </div>

                        @endforeach


                    </div>
            </div>

            <div class="row justify-content-end">
                <div class="col-sm-10 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Send</button>
                    <a href="{{ route('users.all') }}" class="btn btn-secondary">back</a>
                </div>
            </div>
            </form>
        </div>
    </div>
    </div>
@endsection
