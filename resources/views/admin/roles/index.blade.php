@extends('layouts.master')

@section('title')
    {{ __('site.Roles') }}
@endsection

@section('css')
@endsection
@section('content')
    <!-- Multilingual -->
    <div class="card">

        <h5 class="card-header">{{ __('site.Roles') }}</h5>
        <div class="d-flex flex-row-reverse mb-4">
            <button class="btn rounded btn-success  col-2">
                <a href="{{ route('roles.create') }}" class="text-white">
                    {{ __('site.Add') }}</a>
            </button>
        </div>
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
            <div class="table-responsive">
                <table id="em_data" class="display table table-bordered" style="width:100%">

                    <thead>
                        <tr>
                            <th>#{{ __('site.ID') }}</th>
                            <th> {{ __('site.Name') }}</th>
                            <th class="text-center">{{ __('site.Actions') }}</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $key => $role)
                            @if ($role->name !== 'Owner')
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $role->name }} @if ($role->name == auth()->user()->roles_name)
                                            ({{ __('site.YourRole') }})
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @can('Show Role')
                                            <a href="{{ route('roles.show', $role->id) }}" class="btn btn-sm btn-info">
                                                <i class="fa fa-eye"></i> {{ __('site.Show') }}
                                            </a>
                                        @endcan
                                        @can('Edit Role')
                                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-info">
                                                <i class="fa fa-edit"></i> {{ __('site.Edit') }}
                                            </a>
                                        @endcan
                                        @can('Delete Role')
                                            @if ($role->name != auth()->user()->roles_name)
                                                <form id="role-delete-{{ $role->id }}"
                                                    action="{{ route('roles.destroy', $role->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger sa-delete">
                                                        <i class="fa fa-trash"></i> {{ __('site.Delete') }}
                                                    </button>
                                                </form>
                                            @endif
                                        @endcan



                                    </td>

                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--/ Multilingual -->
@endsection
@section('js')
@endsection
