@extends('dashboard.layouts.master')


@section('content')
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">New Role</h5>
            </div>
            <div class="card-body">
                <form action='{{ route('roles.store') }}' method="POST">
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
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Roles</label>
                        <div class="col-10">

                            <div class="form-check mt-3 d-inline-block mx-1 primary-check">
                                <input class="form-check-input " type="checkbox" name='select_all' id="defaultCheck">
                                <label class="form-check-label" for="defaultCheck">
                                    Primary Check
                                </label>
                            </div>

                            @foreach ($permission as $permission_opt)

                                <div class="form-check mt-3 d-inline-block mx-1">
                                    <input class="form-check-input permission  @error('roles') border-danger @enderror"
                                        type="checkbox" value="{{ $permission_opt->id }}" name='permission[]'
                                        id="defaultCheck{{ $permission_opt->id }}"
                                        @if (old('roles')) @foreach (old('roles') as $role_opt)
                            @if ($role_opt == $permission_opt->name)
                                {{ 'checked' }} @endif
                                        @endforeach

                            @endif
                            >
                            <label class="form-check-label" for="defaultCheck{{ $permission_opt->id }}">
                                {{ $permission_opt->name }}
                            </label>
                        </div>

                        @endforeach


                    </div>
            </div>

            <div class="row justify-content-end mt-3">
                <div class="col-sm-10 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Send</button>
                    <a href="{{ route('roles.all') }}" class="btn btn-secondary">back</a>
                </div>
            </div>
            </form>
        </div>
    </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function (){
            $('input[name="select_all"]').click(function() {
                $('input[name="permission[]"]').prop('checked',true);
            });

            $('input[name="permission[]"]').on('change',function (){
                if(this.checked == false){
                    $('input[name="select_all"]').prop('checked',false);
                }
            });
        });
    </script>
@endsection
