@extends('layouts.app')
@section('title')
    {{ 'Update-User' }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12  mx-auto d-flex">
                <div class="card card-animate w-100 ">
                    <div class="card-header">
                        <h4 class="card-title mb-0 project-title">
                            UPDATE USER
                            <a class="btn btn-sm btn-warning" href="{{ route('users.index') }}"><i
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
                        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf @method('PUT')

                            <div class="row p-4">

                                {{-- Full Name --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label"><strong>Full Name</strong></label>
                                        <input type="text" name="name" id="FirstName"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ $user->name }}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email"><strong>Email</strong></label>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ $user->email }}">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Mobile --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="mobile"><strong>Mobile</strong></label>
                                        <input type="text" name="mobile" id="mobile" pattern="\d{10}" maxlength="10"
                                            class="form-control @error('mobile') is-invalid @enderror"
                                            value="{{ $user->mobile }}">
                                        @error('mobile')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Role --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="role_id"><strong>Role</strong></label>
                                        <select name="role_id" id="role_id"
                                            class="form-select @error('role_id') is-invalid @enderror"
                                            onchange="toggleCategoryField()">
                                            <option value="" selected>Select Role</option>
                                            @forelse ($roles as $role)
                                                <option value="{{ $role->id }}"
                                                    {{ $role->id == $user['role_id'] ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @empty
                                            @endforelse
                                        </select>
                                        @error('role_id')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Password --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password"><strong>Password</strong></label>
                                        <input type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Password" value="{{ old('password') }}">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Confirm Password --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password_confirmation"><strong>Confirm Password</strong></label>
                                        <input type="password" name="password_confirmation"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            placeholder="Confirm Password" value="{{ old('password_confirmation') }}">
                                        @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
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
