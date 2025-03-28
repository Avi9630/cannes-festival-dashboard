@extends('layouts.app')
@section('title')
{{ 'Role-Create' }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12  mx-auto d-flex">
                <div class="card card-animate w-100 ">
                    <div class="card-header">
                        <h4 class="card-title mb-0 project-title">
                            CREATE ROLE
                            <a class="btn btn-sm btn-warning" href="{{ route('roles.index') }}"><i
                                    class="ri-arrow-left-line"></i>
                                Back
                            </a>
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
                        <form method="POST" action="{{ route('roles.store') }}" class="forms-sample"> @csrf
                            @method('post')

                            <div class="row p-4">

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label"><strong>Role</strong></label>
                                        <input type="text" name="name" id="FirstName"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name') }}" placeholder="Enter your firstname">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <h4 class="page-title permissions mt-4 mb-4">Permissions</h4>
                                    <div class="permissions-checkbox">
                                        @forelse ($permissions as $permission)
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input ms-0  @error('permissions') is-invalid @enderror"
                                                    type="checkbox" name="permissions[]"
                                                    id="permission-{{ $permission->id }}" value="{{ $permission->id }}"
                                                    {{ in_array($permission->id, old('permissions') ?? []) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permission-{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        @empty
                                            <p>No permissions available.</p>
                                        @endforelse
                                    </div>
                                    @error('permissions')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-12">
                                    <div class="text-end">
                                        <button type="submit" class="btn common-btn">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
