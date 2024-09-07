<!-- roles/edit.blade.php -->
@extends('layouts.master')

@section('title')
    {{ __('site.Edit') }}-{{ $role->name }}
@endsection

@section('css')
@endsection

@section('content')
    <div class="row">
        <!-- Your existing code for header goes here -->
    </div>

    @if (count($errors) > 0)
        <!-- Your existing code for error messages goes here -->
    @endif


    <form action="{{ route('roles.update', $role->id) }}" method="post">
        @csrf
        @method('PUT')
        {{-- <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong> {{ __('site.Name') }}:</strong>
                    {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>{{ __('site.Permissions') }}:</strong>
                    <br />
                    @foreach ($permission as $value)
                        <label>
                            {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions), ['class' => 'name']) }}
                            {{ $value->name }}
                        </label>
                        <br />
                    @endforeach
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">{{ __('site.Update') }}</button>
            </div>
        </div> --}}
        <div class="row">
            <div class="mb-3">
                <label class="form-label" for="bs-validation-name">{{ __('site.Name') }} <span
                        class="text-danger">*</span></label>
                <input name="name" type="text" class="form-control" placeholder="{{ __('site.Name') }}"
                    value="{{ old('name', $role->name) }}">
                @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>
            <div class="mb-3">
                <label class="form-label" for="bs-validation-Permissions">{{ __('site.Permissions') }}
                    <span class="text-danger">*</span></label>
                <div class="form-check">
                    <input class="form-check-input select-all" type="checkbox" id="selectAll">
                    <label class="form-check-label" for="selectAll"> {{ __('site.SelectAll') }}
                    </label>

                </div>
                @foreach ($permission as $value)
                    <div class="form-check">
                        <input name="permission[]" class="form-check-input name" type="checkbox" value="{{ $value->id }}"
                            id="defaultCheck2" @if (in_array($value->id, $rolePermissions)) checked @endif>
                        <label class="form-check-label" for="defaultCheck2"> {{ $value->name }} </label>

                    </div>
                @endforeach
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">{{ __('site.Update') }}</button>
            </div>
        </div>
    </form>
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
    {{-- <script>
        document.getElementById('select-all').onclick = function() {
            var checkboxes = document.querySelectorAll('input[type="checkbox"][name="permission[]"]');
            for (var checkboxe of checkboxes) {
                checkbox.checked = this.checked;
            }
        }
    </script> --}}
@endsection
