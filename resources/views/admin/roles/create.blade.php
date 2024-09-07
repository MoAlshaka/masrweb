@extends('layouts.master')

@section('title')
    {{ __('title.AddRole') }}
@endsection

@section('css')
@endsection

@section('content')
    <div class="row">
        <!-- Bootstrap Validation -->
        <div class="col-md">
            <div class="card">
                <h5 class="card-header">{{ __('site.AddRole') }}</h5>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong> {{ __('site.Whoops!') }} </strong>
                        {{ __('site.SomethingWentWrong') }}<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-body">
                    <form action="{{ route('roles.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="mb-3">
                                <label class="form-label" for="bs-validation-name">{{ __('site.Name') }} <span
                                        class="text-danger">*</span></label>
                                <input name="name" type="text" class="form-control"
                                    placeholder="{{ __('site.Name') }}" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="bs-validation-Permissions">{{ __('site.Permissions') }}
                                    <span class="text-danger">*</span></label>
                                <div class="form-check">
                                    <input class="form-check-input select-all" type="checkbox" id="sellectAll">
                                    <label class="form-check-label" for="sellectAll"> {{ __('site.SelectAll') }}
                                    </label>

                                </div>
                                @foreach ($permission as $value)
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input name" type="checkbox"
                                            value="{{ $value->id }}" id="defaultCheck2">
                                        <label class="form-check-label" for="defaultCheck2"> {{ $value->name }} </label>

                                    </div>
                                @endforeach
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">{{ __('site.Add') }}</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- /Bootstrap Validation -->



@endsection
@section('js')
    <script>
        // Handle the "Select All" checkbox
        const selectAllCheckbox = document.querySelector('.select-all');
        const permissionCheckboxes = document.querySelectorAll('.name');

        selectAllCheckbox.addEventListener('change', function() {
            permissionCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });
    </script>
@endsection
