@extends('layouts.master')

@section('title')
    {{ __('title.Admins') }}
@endsection
@section('css')
@endsection
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('site.Admins') }}</h5>

                </div>
                <div class="d-flex flex-row-reverse mb-4">
                    <a href="{{ route('admins.create') }}" class="btn rounded btn-success  col-2">
                        <span class="text-white">
                            {{ __('site.Add') }}</span>
                    </a>
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
                                    <th>{{ __('site.Name') }}</th>
                                    <th>{{ __('site.UserName') }}</th>
                                    <th>{{ __('site.Roles') }}</th>

                                    <th class="text-center">{{ __('site.Actions') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if ($admins)
                                    @foreach ($admins as $key => $admin)
                                        {{-- Skip users with the role "Owner" --}}
                                        {{-- @if ($admin->roles_name !== 'Owner') --}}
                                        <tr>
                                            <td>{{ $admin->id }}</td>
                                            <td>{{ $admin->name ?? '' }}</td>
                                            <td>{{ $admin->username ?? '' }}@if (auth()->id() == $admin->id)
                                                    (You)
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn rounded-pill btn-primary waves-effect waves-light">{{ $admin->roles_name ?? '' }}</button>
                                            </td>



                                            <td class="text-center">
                                                @can('EditAdmin')
                                                    <a href="{{ route('admins.edit', $admin->id) }}"
                                                        class="btn btn-sm btn-info">
                                                        <i class="fa fa-edit"></i> {{ __('site.Edit') }}
                                                    </a>
                                                @endcan
                                                @can('DeleteAdmin')
                                                    @if (auth()->id() != $admin->id)
                                                        <form id="user-delete-{{ $admin->id }}"
                                                            action="{{ route('admins.destroy', $admin->id) }}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger sa-delete">
                                                                <i class="fa fa-trash"></i> {{ __('site.Delete') }}
                                                            </button>
                                                        </form>
                                                    @endcan
                                                @endif

                                            </td>

                                        </tr>
                                        {{-- @endif --}}
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><!--end row-->

@endsection
@section('js')
@endsection
