@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="pt-4 mb-4 mb-lg-3 pb-lg-4">
            <div class="g-4">
                <div>
                    <form method="GET" action="{{ route('company.search') }}" class="filter-project">@csrf @method('GET')
                        <div class="row">
                            {{-- Comany Name --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="production_house" class="form-label"><strong>Comany Name</strong></label>
                                    <input type="date" name="production_house" id="production_house" class="form-control"
                                        value="{{ isset($payload['production_house']) ? $payload['production_house'] : '' }}"
                                        placeholder="Please enter company name!">
                                </div>
                            </div>

                            {{-- Alumni --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="alumni" class="form-label"><strong>Alumni</strong></label>
                                    <input type="date" name="alumni" id="alumni" class="form-control"
                                        value="{{ isset($payload['alumni']) ? $payload['alumni'] : '' }}"
                                        placeholder="Please enter alumni details!">
                                </div>
                            </div>

                            {{-- Rejected --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input type="checkbox" name="rejected" value="1" style="width: 20px; height:20px;">
                                    &nbsp;<b>Rejected</b>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="name" class="form-label w-100">&nbsp;</label>
                                <button type="submit" class="btn common-btn">SEARCH</button>
                                <a href="{{ route('interestedBy') }}" class="btn common-btn">RESET</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 d-flex">
                <div class="card card-animate w-100 ">
                    <div class="card-header">
                        <h4 class="card-title mb-0 project-title">
                            COMPANY SHOWS INTEREST
                            @if (Auth::check() && !Auth::user()->hasRole('RECRUITER'))
                                <a class="btn btn-sm btn-warning" href="{{ route('alumnis.index') }}">
                                    BACK
                                </a>
                            @endif
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
                            <table class="table custom-table">
                                @if (count($alumnis) > 0)
                                    <thead>
                                        <tr>
                                            <th scope="col">Sr No.</th>
                                            <th scope="col">Company Name</th>
                                            <th scope="col">Recruiter Name</th>
                                            <th scope="col">Alumni Name</th>
                                            <th scope="col">Email ID</th>
                                            <th scope="col">Phone Number</th>
                                            <th scope="col">CMOT Edition</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($alumnis as $key => $alumni)
                                            <tr>
                                                <th> {{ $key + 1 }} </th>
                                                <td> {{ $alumni->production_house }} </td>
                                                <td> {{ $alumni->user_name }} </td>
                                                <td> {{ $alumni->full_name ?? '' }} </td>
                                                <td> {{ $alumni->email ?? '' }} </td>
                                                <td> {{ $alumni->mobile ?? '' }} </td>
                                                <td> {{ $alumni->cmot_edition }} </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @else
                                    <p>No record found...!!</p>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
