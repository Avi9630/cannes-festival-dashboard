@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12  mx-auto d-flex">
                <div class="card card-animate w-100 ">
                    <div class="card-header">
                        <h4 class="card-title mb-0 project-title">
                            UPDATE PERMISSION
                            <a href="{{ route('permissions.index') }}" class="btn btn-sm btn-warning"><i
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
                        <form action="{{ route('permissions.update', [$permission->id]) }}" method="POST">@csrf
                            @method('PUT')
                            <div class="row p-4">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label"><strong>Permission Name</strong></label>
                                        <input type="text" name="name" id="FirstName"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ $permission->name }}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
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
