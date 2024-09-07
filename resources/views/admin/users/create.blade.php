@extends('layouts.master')


@section('title')
    {{ __('title.AddUser') }}
@endsection
@section('css')
@endsection

@section('content')
    <!-- Bootstrap Validation -->
    <div class="col-md">
        <div class="card">
            <h5 class="card-header">{{ __('site.AddUser') }}</h5>
            @if (session()->has('Add'))
                <div class="alert alert-success" role="alert">{{ session()->get('Add') }}</div>
            @endif
            @if (session()->has('Update'))
                <div class="alert alert-primary" role="alert">{{ session()->get('Update') }}</div>
            @endif
            @if (session()->has('Delete'))
                <div class="alert alert-danger" role="alert">{{ session()->get('Delete') }}</div>
            @endif
            @if (session()->has('Warning'))
                <div class="alert alert-warning" role="alert">{{ session()->get('Warning') }}</div>
            @endif
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="bs-validation-name">{{ __('site.Name') }} <span
                                class="text-danger">*</span></label>
                        <input name="name" type="text" class="form-control" placeholder="{{ __('site.Name') }}"
                            value="{{ old('name') }}">
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">

                        <label class="form-label" for="bs-validation-email">{{ __('site.Email') }} <span
                                class="text-danger">*</span></label>
                        <input name="email" type="email" class="form-control" placeholder="{{ __('site.EnterEmail') }}"
                            value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 form-password-toggle">
                        <label class="form-label" for="bs-validation-password">{{ __('site.Password') }} <span
                                class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                            <input name="password" id="bs-validation-password" type="password" class="form-control"
                                placeholder="{{ __('site.Password') }}">
                            <span class="input-group-text cursor-pointer" id="basic-default-password4"><i
                                    class="ti ti-eye-off"></i></span>

                        </div>
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif

                    </div>

                    <div class="mb-3 form-password-toggle">
                        <label class="form-label" for="bs-validation-password">{{ __('site.ConfirmPassword') }} <span
                                class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                            <input name="password_confirmation" id="bs-validation-password" type="password"
                                class="form-control" placeholder="{{ __('site.ConfirmPassword') }}">
                            <span class="input-group-text cursor-pointer" id="basic-default-password4"><i
                                    class="ti ti-eye-off"></i></span>
                        </div>
                    </div>
                    <div class="mb-3">

                        <label class="form-label" for="bs-validation-phone">{{ __('site.Phone') }} <span
                                class="text-danger">*</span></label>
                        <input name="phone" type="text" class="form-control" placeholder="{{ __('site.Phone') }} "
                            value="{{ old('phone') }}">
                        @if ($errors->has('phone'))
                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">

                        <label class="form-label" for="bs-validation-address">{{ __('site.Address') }} <span
                                class="text-danger">*</span></label>
                        <input name="address" type="text" class="form-control" placeholder="{{ __('site.Address') }} "
                            value="{{ old('address') }}">
                        @if ($errors->has('address'))
                            <span class="text-danger">{{ $errors->first('address') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="bs-validation-status">{{ __('site.Status') }} <span
                                class="text-danger">*</span></label>
                        <select name="status" class="select2 form-select" id="select2_status">
                            <option value="1" @if (old('status') == '1') selected @endif>
                                {{ __('site.Active') }}</option>
                            <option value="0" @if (old('status') == '0') selected @endif>
                                {{ __('site.InActive') }}</option>


                        </select>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">{{ __('site.Add') }}</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
<!-- /Bootstrap Validation -->
@section('js')
@endsection
