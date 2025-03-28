@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="pt-4 mb-4 mb-lg-3 pb-lg-4">
            <div class="g-4">
                <div>
                    <form method="GET" action="{{ route('alumni.search') }}" class="filter-project">@csrf @method('GET')
                        <div class="row">
                            {{-- Select Genre --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category_id"><strong>Film Craft</strong></label>
                                    <select name="category_id" id="category_id" class="form-select">
                                        <option value="">Select film craft</option>
                                        @foreach ($categories as $category)
                                            <option name="category_id" value="{{ $category->id }}"
                                                {{ isset($payload['category_id']) && $payload['category_id'] == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- From Date --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cmot_edition_year" class="form-label"><strong>CMOT Edition</strong></label>
                                    <input type="number" name="cmot_edition_year" id="cmot_edition_year"
                                        class="form-control"
                                        value="{{ isset($payload['cmot_edition_year']) ? $payload['cmot_edition_year'] : '' }}"
                                        placeholder="Edition year!">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="name" class="form-label w-100">&nbsp;</label>
                                <button type="submit" class="btn common-btn">SEARCH</button>
                                <a href="{{ route('alumnis.index') }}" class="btn common-btn">RESET</a>
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
                            ALUMNI
                            @if (Auth::check() && !Auth::user()->hasRole('RECRUITER'))
                                <a class="btn btn-sm btn-warning" href="{{ route('interestedBy') }}">
                                    Interested By Company
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
                                            <th scope="col">Sr.No</th>
                                            <th scope="col">Full Name</th>
                                            {{-- @if (Auth::check() && !Auth::user()->hasRole('RECRUITER')) --}}
                                            <th scope="col">Email ID</th>
                                            <th scope="col">Phone Number</th>
                                            {{-- @endif --}}
                                            <th scope="col">Age</th>
                                            <th scope="col">Film Craft</th>
                                            <th scope="col">CMOT Edition</th>
                                            {{-- @if (Auth::check() && !Auth::user()->hasRole('RECRUITER')) --}}
                                            <th scope="col" width="280px">Action</th>
                                            {{-- @endif --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($alumnis as $key => $alumni)
                                            <tr>
                                                <th> {{ $alumni->id }} </th>
                                                <td> {{ $alumni->full_name }} </td>
                                                {{-- @if (Auth::check() && !Auth::user()->hasRole('RECRUITER')) --}}
                                                <td> {{ $alumni->email }} </td>
                                                <td> {{ $alumni->mobile }} </td>
                                                {{-- @endif --}}
                                                <td> {{ $alumni->age }} </td>
                                                <td> {{ $alumni->category->name ?? '' }} </td>
                                                <td> {{ $alumni->cmot_edition }} </td>

                                                <td class="action-btn">
                                                    <div class="view-edit-delete">
                                                        @can('view')
                                                            <a href="{{ route('alumnis.show', $alumni->id) }}">
                                                                <i class="ri-eye-fill black-text"></i>
                                                            </a>
                                                        @endcan
                                                        @can('delete')
                                                            <form action="{{ route('alumnis.destroy', $alumni->id) }}"
                                                                method="post" style="display: inline"
                                                                onsubmit="return confirmDelete()">
                                                                @csrf @method('DELETE')
                                                                <button type="submit " class="deletebtn">
                                                                    <i class="ri-delete-bin-fill "></i>
                                                                </button>
                                                            </form>
                                                        @endcan
                                                    </div>

                                                    @if (Auth::check() && Auth::user()->hasRole('RECRUITER'))
                                                        @if ($alumni::selected($alumni->id))
                                                            <span class="selected-alumni"
                                                                style="width: 10px; height: 10px; border-radius: 100%; background-color: green; display: inline-block;"></span>
                                                        @elseif($alumni::rejected($alumni->id))
                                                            <span class="selected-rejected"
                                                                style="width: 10px; height: 10px; border-radius: 100%; background-color: red; display: inline-block;"></span>
                                                        @else
                                                            <span class="selected-rejected"
                                                                style="width: 10px; height: 10px; border-radius: 100%; background-color: yellow; display: inline-block;"></span>
                                                        @endif
                                                    @endif
                                                </td>

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
