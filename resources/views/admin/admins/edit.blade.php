@extends('layouts.master')

@section('title')
    {{ __('title.EditAdmin') }}
@endsection
@section('css')
@endsection

@section('content')
    <!-- Bootstrap Validation -->
    <div class="col-md">
        <div class="card">
            <h5 class="card-header">{{ __('site.EditAdmin') }}</h5>
            <div class="card-body">
                <form action="{{ route('admins.update', $admin->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label" for="bs-validation-name"> {{ __('site.Name') }} <span
                                class="text-danger">*</span></label>
                        <input name="name" type="text" class="form-control" placeholder="{{ __('site.Name') }}"
                            value="{{ $admin->name ?? '' }}">
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="bs-validation-email">{{ __('site.UserName') }} <span
                                class="text-danger">*</span></label>
                        <input name="username" type="text" class="form-control" placeholder="{{ __('site.UserName') }}"
                            value="{{ $admin->username ?? '' }}">
                        @if ($errors->has('username'))
                            <span class="text-danger">{{ $errors->first('username') }}</span>
                        @endif
                    </div>


                    <div class="mb-3 form-password-toggle">
                        <label class="form-label" for="bs-validation-password">{{ __('site.Password') }} <span
                                class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                            <input name="password" id="bs-validation-password" type="password" class="form-control"
                                placeholder="{{ __('site.Password') }}"
                                @if (!$errors->has('password')) value="{{ old('password') }}" @endif>
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                            <span class="input-group-text cursor-pointer" id="basic-default-password4">
                                <i class="ti ti-eye-off"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="bs-validation-role">{{ __('site.Roles') }} <span
                                class="text-danger">*</span></label>
                        <select name="roles_name" class="select2 form-control" id="select2_role">
                            <option value="" selected disabled></option>
                            @foreach ($roles as $role)
                                @if ($role !== 'Owner')
                                    <option value="{{ $role }}"
                                        {{ in_array($role, $adminRole) ? 'selected' : '' }}>{{ $role }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="bs-validation-role">{{ __('site.Status') }} <span
                                class="text-danger">*</span></label>
                        <select name="status" class="select2 form-select" id="select2_role">
                            <option value="0" @if (old('status') == '0' || $admin->status == 0) selected @endif>
                                {{ __('site.InActive') }}</option>
                            <option value="1" @if (old('status') == '1' || $admin->status == 1) selected @endif>
                                {{ __('site.Active') }}</option>

                        </select>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">{{ __('site.Update') }}</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Bootstrap Validation -->
@endsection
@section('js')
@endsection
