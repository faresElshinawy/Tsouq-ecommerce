@extends('endUser.layouts.master')


@section('title','tsouq Profile')


@section('page title',Setting::get('profile-header'))

@section('page',Setting::get('profile-title'))

@section('content')
@include('endUser.layouts.header')
<div class=" pb-3">
    <div class="col-12 pb-1 d-flex justify-content-center p-3">
        <div class=" col-8  py-8">

            <!-- Content -->

            <div class="row">
                <div class="col-md-12">
                  <div class="card mb-4">
                    <h5 class="card-header bg-primary text-light">Profile Details</h5>
                    <!-- Account -->
                    <div class="card-body">
                      <div class="d-flex align-items-start align-items-sm-center gap-4">
                        @if (File::exists(public_path('uploads/users/' . $user->image)) && $user->image != null)
                            <img
                            src="{{ asset('uploads/users/' . $user->image) }}"
                            alt="user-avatar"
                            class="d-block rounded"
                            height="100"
                            width="100"
                            id="uploadedAvatar"
                            />
                        @endif
                        <form action="{{route('end-user.profile.image.update')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            <div class="button-wrapper ml-3" >
                              <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                <span class="d-none d-sm-block">Upload new photo</span>
                                <i class="bx bx-upload d-block d-sm-none"></i>
                                <input
                                type="file"
                                id="upload"
                                class="account-file-input"
                                name="image"
                                hidden
                                />
                            </label>
                            <button class="btn btn-outline-secondary  mb-4">
                                <i class="bx bx-reset d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">submit</span>
                            </button>

                              <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                              @error('image')
                              <span class="text-danger">{{$message}}</span>
                              @enderror
                            </div>
                        </form>
                      </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">
                      <form  action="{{route('end-user.profile.update')}}" method="post" >
                        @csrf
                        @method('put')
                        <div class="row">
                          <div class="mb-3 col-md-6 hide">
                            <label for="Name" class="form-label">Name</label>
                            @error('name')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                            <input class="form-control" type="text" name="name" id="Name" value="{{ old('name') ?? $user->name}}" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">E-mail</label>
                            @error('email')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <input
                              class="form-control"
                              type="text"
                              id="email"
                              name="email"
                              value="{{ old('email') ?? $user->email}}"
                              placeholder="Enter Your Email"
                            />
                          </div>



                          <div class="mb-3 col-md-6">
                            <label for="password" class="form-label">Password</label>
                            @error('password')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <input
                              class="form-control"
                              type="text"
                              id="password"
                              name="password"
                              placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            />
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="password-confirm" class="form-label">Password Confirm</label>
                            @error('password')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <input
                              class="form-control"
                              type="text"
                              id="password-confirm"
                              name="password_confirmation"
                              placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            />
                          </div>



                        </div>
                        <div class="mt-2">
                          <button type="submit" class="btn btn-primary me-2">Save changes</button>
                        </div>
                      </form>
                    </div>
                    <!-- /Account -->
                  </div>
                  <div class="card">
                    <h5 class="card-header bg-primary text-light">Delete Account</h5>
                    <div class="card-body">
                      <div class="mb-3 col-12 mb-0">
                        <div class="alert alert-warning">
                          <h6 class="alert-heading fw-bold mb-1">Are you sure you want to delete your account?</h6>
                          <p class="mb-0">Once you delete your account, there is no going back. Please be certain.</p>
                        </div>
                      </div>
                      <form method="post" action="{{ route('end-user.profile.destroy') }}" class="p-6">
                        @csrf
                        @method('delete')
                          <div class="mb-3 col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input
                            class="form-control"
                            type="text"
                            id="password"
                            name="password_deletion"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            />
                            @error('password_deletion')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                          </div>

                          <div class="mb-3 ml-2 col-md-6">

                                <div class="form-check mb-3">
                                    <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="accountActivation"
                                    id="accountActivation"
                                    />
                                    <label class="form-check-label" for="accountActivation"
                                    >I confirm my account deactivation</label
                                    >

                                </div>
                          </div>
                        <button type="submit" class="btn btn-danger ml-3 deactivate-account">Deactivate Account</button>
                      </form>
                    </div>
                  </div>
                </div>
            </div>
            <!-- / Content -->

        </div>
    </div>
</div>
@endsection


