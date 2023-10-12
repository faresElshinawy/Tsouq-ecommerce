@extends('dashboard.layouts.master')


@section('content')
    <div class="py-12">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">
                profile
                /</span>
            @auth
                {{ auth()->user()->name }}
            @endauth
        </h4>

        <div class=" card">
            <div class="max-w-xl">

                <header class="card-header">
                    <h2 >
                        {{ __('Profile Image') }}
                    </h2>

                    <p class="mt-1 text-sm text-muted">
                        {{ __('Update Your Profile Image.') }}
                    </p>
                </header>
                <div class="d-flex justify-content-center card-img">
                    @if (File::exists(public_path('uploads/users/' . $user->image)))
                        <img src="{{ asset('uploads/users/' . $user->image) }}"
                            class="w-px-200  h-auto rounded-square img-fluid" alt="">
                    @endif
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @method('patch')
                        @csrf
                        <div>
                            <x-input-label for="image" :value="__('Change Image')" />
                            <x-text-input id="image" name="image" type="file" class="form-control my-2"
                                autocomplete="image" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <button class="btn btn-primary">save</button>

                            @if (session('status') === 'profile-updated')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600"
                                >{{ __('Saved.') }}</p>
                            @endif
                        </div>

                    </form>
                </div>

            </div>
        </div>

                    @include('dashboard.pages.profile.partials.update-profile-information-form')

                    @include('dashboard.pages.profile.partials.update-password-form')

        </div>
    </div>
@endsection
