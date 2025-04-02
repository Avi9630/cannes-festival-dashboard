@extends('layouts.app')
@section('title')
    {{ 'User List' }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="pt-4 mb-4 mb-lg-3 pb-lg-4">
            <div class="g-4">
                <div>
                    <form action="{{ route('user.search') }}" method="GET" class="filter-project">@csrf @method('GET')
                        <div class="row">

                            {{-- Email --}}
                            {{-- <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label"><strong>Email</strong></label>
                                    <input type="text" name="email" class="form-control"
                                        value="{{ isset($payload['email']) ? $payload['email'] : '' }}"
                                        placeholder="Please select email..">
                                </div>
                            </div> --}}

                            <div class="col-md-6">
                                <label for="role_id" class="form-label">Select Role</label>
                                <select name="role_id" class="form-select">
                                    <option value="">Select role</option>
                                    @foreach ($roles as $role)
                                        <option name="role_id" value="{{ $role->id }}"
                                            {{ isset($payload['role_id']) && $payload['role_id'] == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-xxl-2 col-md-2">
                                <label for="basiInput" class="form-label w-100">&nbsp;</label>
                                <button class="btn common-btn  w-100"><i class="ri-search-line search-icon"></i>
                                    Search</button>
                            </div>
                        </div>
                    </form>
                    <div class="text-end">
                        <a href="{{ route('users.index') }}" class="btn common-btn">RESET</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 d-flex">
                <div class="card card-animate w-100 ">
                    <div class="card-header">
                        <h4 class="card-title mb-0 project-title">
                            USERS
                            @can('create-user')
                                <a href="{{ route('users.create') }}" class="btn btn-sm btn-warning">CREATE</a>
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
                                @if (count($users) > 0)
                                    <thead>
                                        <tr>
                                            <th scope="col">Sr.No</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Mobile</th>
                                            <th scope="col">Roles</th>
                                            <th scope="col" width='100'>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $key => $user)
                                            <tr>
                                                <th> {{ $user->id }} </th>
                                                <td> {{ $user['name'] }} </td>
                                                <td> {{ $user['email'] }} </td>
                                                <td> {{ $user['mobile'] }} </td>

                                                <td>
                                                    @if ($user->getRoleNames()->isEmpty())
                                                        @can('assign-role')
                                                            <a href="{{ url('assign_role', $user->id) }}"
                                                                class="btn btn-sm btn-success">ASSIGN-ROLE</a>
                                                        @endcan
                                                    @else
                                                        {{ $user->getRoleNames()->implode('", "') }}
                                                    @endif
                                                </td>

                                                <td class="action-btn">
                                                    <div class="view-edit-delete">
                                                        {{-- @can('view-user')
                                                            <a href="{{ route('users.show', $user->id) }}">
                                                                <i class="ri-eye-fill black-text"></i>
                                                            </a>
                                                        @endcan --}}
                                                        @can('edit-user')
                                                            <a href="{{ route('users.edit', $user->id) }}"><i
                                                                    class="ri-pencil-fill "></i>
                                                            </a>
                                                        @endcan

                                                        @can('delete-user')
                                                            <form action="{{ route('users.destroy', $user->id) }}"
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
                        <nav aria-label="...">
                            <ul class="pagination">
                                {{ $users->withQueryString()->links() }}
                            </ul>
                        </nav>
                        <!-- Pagination End-->
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
    </div>
@endsection
