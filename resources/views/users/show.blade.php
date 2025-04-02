@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-sm-8  mx-auto d-flex">
                <div class="card card-animate w-100 ">
                    <div class="card-header">
                        <h4 class="card-title mb-0 project-title">User Information
                            <a href="{{ route('users.index') }}" class="btn btn-warning">&larr; Back</a>
                        </h4>
                    </div>
                    <div class="card-body">

                        <div class="mb-3 row">
                            <label for="name"
                                class="col-md-4 col-form-label text-md-end text-start"><strong>Name:</strong></label>
                            <div class="col-md-6" style="line-height: 35px;">
                                {{ $user->name }}
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="name"
                                class="col-md-4 col-form-label text-md-end text-start"><strong>Email:</strong></label>
                            <div class="col-md-6" style="line-height: 35px;">
                                {{ $user->email }}
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="name"
                                class="col-md-4 col-form-label text-md-end text-start"><strong>Mobile:</strong></label>
                            <div class="col-md-6" style="line-height: 35px;">
                                {{ $user->mobile }}
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="name"
                                class="col-md-4 col-form-label text-md-end text-start"><strong>Username:</strong></label>
                            <div class="col-md-6" style="line-height: 35px;">
                                {{ $user->username }}
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="name"
                                class="col-md-4 col-form-label text-md-end text-start"><strong>Role:</strong></label>
                            <div class="col-md-6" style="line-height: 35px;">
                                {{ $user->role_id == 1 ? 'SUPERADMIN' : ($user->role_id == 2 ? 'ADMIN' : ($user->role_id == 3 ? 'JURY' : ($user->role_id == 4 ? 'GRAND-JURY' : ($user->role_id == 5 ? 'OTHERS' : 'Not Define')))) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
