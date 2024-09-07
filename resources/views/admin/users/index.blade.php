@extends('layouts.master')

@section('title')
    {{ __('title.Users') }}
@endsection
@section('css')
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('site.Users') }}</h5>

                </div>
                <div class="d-flex flex-row-reverse mb-4">
                    <a href="{{ route('users.create') }}" class="btn rounded btn-success  col-2">
                        <span href="{{ route('users.create') }}" class="text-white">
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
                                    <th>{{ __('site.Email') }}</th>
                                    <th>{{ __('site.Phone') }}</th>
                                    <th>{{ __('site.Status') }}</th>


                                    <th class="text-center">{{ __('site.Actions') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if ($users)
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name ?? '' }}</td>
                                            <td>{{ $user->email ?? '' }} </td>
                                            <td>{{ $user->phone ?? '' }} </td>
                                            <td>
                                                @if ($user->status == 1)
                                                    <span class="badge bg-success">{{ __('site.Active') }}</span>
                                                @else
                                                    <span class="badge bg-danger">{{ __('site.Inactive') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center d-flex">
                                                @can('EditUser')
                                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-info">
                                                        <i class="fa fa-edit"></i> {{ __('site.Edit') }}
                                                    </a>
                                                @endcan
                                                @can('DeleteUser')
                                                    <form id="user-delete-{{ $user->id }}"
                                                        action="{{ route('users.destroy', $user->id) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger sa-delete">
                                                            <i class="fa fa-trash"></i> {{ __('site.Delete') }}
                                                        </button>
                                                    </form>
                                                @endcan


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
