@extends('layouts.master')

@section('title')
    {{ __('title.EditUser') }}
@endsection
@section('css')
@endsection

@section('content')
    <!-- Bootstrap Validation -->
    <div class="col-md">
        <div class="card">
            <h5 class="card-header">{{ __('site.EditUser') }}</h5>
            <div class="card-body">
                <form action="{{ route('users.update', $user->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label" for="bs-validation-name"> {{ __('site.Name') }} <span
                                class="text-danger">*</span></label>
                        <input name="name" type="text" class="form-control" placeholder="{{ __('site.Name') }}"
                            value="{{ old('name', $user->name) }}">
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="bs-validation-email">{{ __('site.Email') }} <span
                                class="text-danger">*</span></label>
                        <input name="email" type="email" class="form-control" placeholder="{{ __('site.Email') }}"
                            value="{{ old('email', $user->email) }}">
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
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
                        <label class="form-label" for="bs-validation-phone">{{ __('site.Phone') }} <span
                                class="text-danger">*</span></label>
                        <input name="phone" type="phone" class="form-control" placeholder="{{ __('site.Phone') }}"
                            value="{{ old('phone', $user->phone) }}">
                        @if ($errors->has('phone'))
                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="bs-validation-address">{{ __('site.Address') }} <span
                                class="text-danger">*</span></label>
                        <input name="address" type="address" class="form-control" placeholder="{{ __('site.Address') }}"
                            value="{{ old('address', $user->address) }}">
                        @if ($errors->has('address'))
                            <span class="text-danger">{{ $errors->first('address') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="bs-validation-status">{{ __('site.Status') }} <span
                                class="text-danger">*</span></label>
                        <select name="status" class="select2 form-select" id="select2_status">
                            <option value="0" @if (old('status') == '0' || $user->status == 0) selected @endif>
                                {{ __('site.InActive') }}</option>
                            <option value="1" @if (old('status') == '1' || $user->status == 1) selected @endif>
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
