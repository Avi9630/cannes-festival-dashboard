@extends('auth.layouts.main')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card  mt-4">
                <div class="card-body p-4">
                    <div class="text-center mt-2">
                        <h5 class="text-primary">Enter OTP for account verification</h5>
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
                        <form method="POST" action="{{ route('verifyOtp') }}"> @csrf @method('post')
                            <div class="mb-3">
                                <label for="email" class="form-label">OTP</label>
                                <input type="text" class="form-control form-control @error('otp') is-invalid @enderror"
                                    name="otp" value="{{ old('otp') }}" placeholder="Please provide OTP" autofocus>
                                @error('otp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mt-4">
                                <button class="btn common-btn w-100" type="submit">Verify OTP</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="mt-4 text-center">
                <p class="mb-0"><a href="{{ route('login') }}" class="text-primary"><b>Login</b></a>
                </p>
            </div>
        </div>
    </div>
@endsection
