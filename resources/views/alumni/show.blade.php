@extends('layouts.app')
@section('content')
    <div class="container-fluid page-body-wrapper">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 stretch-card">
                    <div class="card">

                        @foreach (['success', 'info', 'danger', 'warning'] as $msg)
                            @if (Session::has($msg))
                                <div id="flash-message" class="alert alert-{{ $msg }}" role="alert">
                                    {{ Session::get($msg) }}
                                </div>
                            @endif
                        @endforeach

                        <div class="card-header">
                            <div class="float-end">
                                <a href="{{ route('alumnis.index') }}" class="btn btn-sm btn-warning">&larr; Back</a>
                            </div>
                            <h4 class="card-title">PREVIEW</h4>
                        </div>

                        <div class="card-body">
                            <br>

                            <div class="card">
                                <div class="card-body">
                                    <div class="row pt-2">

                                        <div class="col-md-4">
                                            <p><strong>Full Name : </strong> {{ $alumni->full_name ?? '' }}</p>
                                        </div>

                                        @if (Auth::check() && !Auth::user()->hasRole('RECRUITER'))
                                            <div class="col-md-4">
                                                <p><strong>Email : </strong> {{ $alumni->email ?? '' }}</p>
                                            </div>

                                            <div class="col-md-4">
                                                <p><strong>Mobile : </strong> {{ $alumni->mobile ?? '' }}</p>
                                            </div>
                                        @endif

                                        <div class="col-md-4">
                                            <p><strong>Age : </strong> {{ $alumni->age ?? '' }}</p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Gender : </strong> {{ $alumni->gender ?? '' }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><strong>Film Craft : </strong> {{ $alumni->category->name ?? '' }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><strong>Address : </strong> {{ $alumni->address ?? '' }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><strong>Current Designation : </strong>
                                                {{ $alumni->current_designation ?? '' }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><strong>Edition : </strong> {{ $alumni->cmot_edition ?? '' }}</p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>CV : </strong>
                                                <a href="{{ $alumni->cv ?? '' }}" target="_blank">{{ $alumni->cv ?? '' }}
                                                </a>
                                            </p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Showreel : </strong>
                                                <a href="{{ $alumni->showreels ?? '' }}"
                                                    target="_blank">{{ $alumni->showreels ?? '' }}
                                                </a>
                                            </p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Additional Information : </strong>
                                                <a href="{{ $alumni->additional_info ?? '' }}"
                                                    target="_blank">{{ $alumni->additional_info ?? '' }}
                                                </a>
                                            </p>
                                        </div>

                                        <a href=""></a>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex" style="margin-left:400px; margin-top: 15px;">
                                @if (Auth::check() && Auth::user()->hasRole('RECRUITER'))
                                    <a href="{{ route('alumni.select', $alumni->id) }}" class="btn btn-sm btn-primary"
                                        style="margin-right: 5px;">Select</a>

                                    <a href="{{ route('alumni.reject', $alumni->id) }}"
                                        class="btn btn-sm btn-primary">Reject</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
