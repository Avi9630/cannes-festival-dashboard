@extends('layouts.app')
@section('title')
    {{ 'Create-User' }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12  mx-auto d-flex">
                <div class="card card-animate w-100 ">
                    <div class="card-header">
                        <h4 class="card-title mb-0 project-title">
                            CREATE USER
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
                        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">@csrf
                            @method('POST')
                            <div class="row p-4">

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label"><strong>Full Name</strong></label>
                                        <input type="text" name="name" id="FirstName"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name') }}" placeholder="Enter your firstname">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email"><strong>Email</strong></label>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="Enter your email" value="{{ old('email') }}">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="mobile"><strong>Mobile</strong></label>
                                        <input type="text" name="mobile" id="mobile" pattern="\d{10}" maxlength="10"
                                            class="form-control @error('mobile') is-invalid @enderror"
                                            placeholder="Enter your mobile" value="{{ old('mobile') }}">
                                        @error('mobile')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="role_id"><strong>Role</strong></label>
                                        <select name="role_id" id="role_id"
                                            class="form-select @error('role_id') is-invalid @enderror"
                                            onchange="toggleCategoryField()">
                                            <option value="" selected>Select Role</option>
                                            @forelse ($roles as $role)
                                                <option value="{{ $role->id }}"
                                                    {{ old('role_id') == $role->id ? 'selected' : '' }}>
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

                                {{-- <div class="col-md-6" id="categoryField" style="display: none;">
                                    <div class="mb-3">
                                        <label for="cmot_category_id"><strong>Category</strong></label>
                                        <select name="cmot_category_id" id="cmot_category_id"
                                            class="form-select @error('cmot_category_id') is-invalid @enderror"
                                            style="height: 100%;">
                                            <option value="">Select Category</option>
                                            @forelse ($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ old('cmot_category_id') == $category->id ? 'selected' : '' }}
                                                    {{ $category->name }}
                                                </option>
                                            @empty
                                            @endforelse
                                        </select>
                                        @error('cmot_category_id')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6" id="productionHouse" style="display: none;">
                                    <div class="mb-3">
                                        <label for="name"><strong>Production House</strong></label>
                                        <input type="text" name="production_house"
                                            class="form-control @error('production_house') is-invalid @enderror"
                                            value="{{ old('production_house') }}">
                                        @error('production_house')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div> --}}

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
