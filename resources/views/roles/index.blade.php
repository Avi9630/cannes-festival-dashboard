@extends('layouts.app')
@section('title')
    {{ 'Role-List' }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 d-flex">
                <div class="card card-animate w-100 ">
                    <div class="card-header">
                        <h4 class="card-title mb-0 project-title">
                            ROLES
                            @can('create-role')
                                <a href="{{ route('roles.create') }}" class="btn btn-sm btn-warning">Create</a>
                            @endcan
                        </h4>
                    </div>
                    <div class="card-body">
                        <span>
                            <h4 class="alert-danger"></h4>
                        </span>
                        @foreach (['success', 'info', 'danger', 'warning'] as $msg)
                            @if (Session::has($msg))
                                <div id="flash-message" class="alert alert-{{ $msg }}" role="alert">
                                    {{ Session::get($msg) }}
                                </div>
                            @endif
                        @endforeach
                        <div class="table table-responsive">
                            <table class="table">
                                @if (count($roles) > 0)
                                    <thead>
                                        <tr>
                                            <th scope="col">Sr.No</th>
                                            <th scope="col">Name</th>
                                            <th scope="col" width='100'>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($roles as $key => $role)
                                            <tr>
                                                <th> {{ $role->id }} </th>
                                                <td> {{ $role['name'] }} </td>


                                                <td class="action-btn">
                                                    <div class="view-edit-delete">
                                                        {{-- @can('view-role')
                                                            <a href="{{ route('roles.show', $role->id) }}">
                                                                <i class="ri-eye-fill black-text"></i>
                                                            </a>
                                                        @endcan --}}
                                                        @can('edit-role')
                                                            <a href="{{ route('roles.edit', $role->id) }}"><i
                                                                    class="ri-pencil-fill "></i>
                                                            </a>
                                                        @endcan

                                                        @can('delete-role')
                                                            @if ($role->name != Auth::user()->hasRole($role->name))
                                                                <form action="{{ route('roles.destroy', [$role->id]) }}"
                                                                    method="post" style="display: inline"
                                                                    onsubmit="return confirmDelete()">
                                                                    @csrf @method('DELETE')
                                                                    <button type="submit " class="deletebtn">
                                                                        <i class="ri-delete-bin-fill "></i>
                                                                    </button>
                                                                </form>
                                                            @endcan
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @else
                                    <p>No record found...!!</p>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
