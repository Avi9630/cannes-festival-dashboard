@extends('auth.layouts.main')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card  mt-4">
                <div class="card-body p-4">
                    <div class="text-center mt-2">
                        <h5 class="text-primary">Change your password</h5>
                    </div>
                    <div class="text-center mt-2">
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
                    </div>

                    <div class="p-2 mt-4">
                        <form method="POST" action="{{ route('changePassword') }}"> @csrf @method('post')
                            <div class="mb-3">
                                <label for="email" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" placeholder="PASSWORD" autofocus>
                                @error('password')
                                    <span class="invalid-feedback pull-left " role="alert"
                                        style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name" class="pull-left"><strong>Confirm
                                        Password</strong></label>
                                <input type="password" name="password_confirmation"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    placeholder="Confirm Password" value="{{ old('password_confirmation') }}">
                                @error('password_confirmation')
                                    <span class="invalid-feedback pull-left" role="alert"
                                        style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <button class="btn common-btn w-100" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end card body -->
            </div>
        </div>
    </div>
@endsection
