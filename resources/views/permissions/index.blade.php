@extends('layouts.app')
@section('title')
    {{ 'Permissions List' }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="pt-4 mb-4 mb-lg-3 pb-lg-4">
            <div class=" g-4">
                <div>
                    <form class="filter-project" method="GET" action="{{ route('permissions.search') }}">@csrf
                        @method('GET')
                        <div class="col-md-6 mx-auto">
                            <div class="row">
                                <div class="col-xxl-6 col-md-8">
                                    <label for="basiInput" class="form-label">Search</label>
                                    <input type="text" name="search" class="form-control" value="{{ isset($payload['search']) ? $payload['search'] : '' }}" placeholder="Search">
                                </div>
                                <div class="col-xxl-4 col-md-4">
                                    <label for="basiInput" class="form-label w-100">&nbsp;</label>
                                    <button class="btn common-btn "><i class="ri-search-line search-icon"></i>
                                        Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="text-end">
                        <a href="{{ route('permissions.index') }}" class="btn common-btn">RESET</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 d-flex">
                <div class="card card-animate w-100 ">
                    <div class="card-header">
                        <h4 class="card-title mb-0 project-title">
                            PERMISSIONS
                            @can('create-permission')
                                <a href="{{ route('permissions.create') }}" class="btn btn-sm btn-warning">Create</a>
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
                                @if (count($permissions) > 0)
                                    <thead>
                                        <tr>
                                            <th scope="col">Sr.No</th>
                                            <th scope="col">Name</th>
                                            <th scope="col" width="100">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($permissions as $key => $permission)
                                            <tr>
                                                <td> {{ $key + 1 }} </td>
                                                <td> {{ $permission['name'] }} </td>

                                                <td class="action-btn">
                                                    <div class="view-edit-delete">
                                                        {{-- @can('view-permission')
                                                            <a href="{{ route('permissions.show', $permission->id) }}">
                                                                <i class="ri-eye-fill black-text"></i>
                                                            </a>
                                                        @endcan --}}
                                                        @can('edit-permission')
                                                            <a href="{{ route('permissions.edit', $permission->id) }}"><i
                                                                    class="ri-pencil-fill "></i>
                                                            </a>
                                                        @endcan

                                                        @can('delete-permission')
                                                            <form action="{{ route('permissions.destroy', [$permission->id]) }}"
                                                                method="post" style="display: inline"
                                                                onsubmit="return confirmDelete()">
                                                                @csrf @method('DELETE')
                                                                <button type="submit " class="deletebtn">
                                                                    <i class="ri-delete-bin-fill "></i>
                                                                </button>
                                                            </form>
                                                        @endcan
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
                        <!-- Pagination -->
                        {{-- <nav aria-label="...">
                            <ul class="pagination">
                                {{ $permissions->withQueryString()->links() }}
                            </ul>
                        </nav> --}}
                        <!-- Pagination End-->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
