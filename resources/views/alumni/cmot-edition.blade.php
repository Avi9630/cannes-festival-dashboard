@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="row">

            <form method="GET" action="{{ route('cmot-edition-search') }}" class="forms-sample"> @csrf
                @method('GET')
                <div class="form-group">
                    <label for="name">Edition Year</label>
                    <div class="d-flex align-items-center">
                        <div style="width: 60%">
                            <input type="number" name="year" class="form-control" value="{{ old('year') }}">
                        </div>
                        <div class="d-flex" style="margin-left: 30px">
                            <button type="submit" class="btn btn-sm btn-gradient-primary me-2">Search</button><br><br>
                        </div>
                    </div>
                </div>
            </form>

            <div class="col-lg-12 stretch-card">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Alumni</h4>

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

                        <div class="w-100 overflow-auto">
                            <table class="table table-bordered">
                                @if (count($alumnis) > 0)
                                    <thead>
                                        <tr>
                                            <th scope="col">Sr.Nom</th>
                                            <th scope="col">Full Name</th>
                                            @if (Auth::check() && !Auth::user()->hasRole('RECRUITER'))
                                                <th scope="col">Email</th>
                                                <th scope="col">Mobile</th>
                                            @endif
                                            <th scope="col">Age</th>
                                            <th scope="col">Film Craft</th>
                                            <th scope="col">CMOT Edition</th>
                                            @if (Auth::check() && Auth::user()->hasRole('RECRUITER'))
                                                <th scope="col">Interest</th>
                                            @endif
                                            <th scope="col" width="280px">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @forelse ($alumnis as $key => $alumni)
                                            <tr>
                                                <th> {{ $alumni->id }} </th>
                                                <td> {{ $alumni->full_name }} </td>
                                                @if (Auth::check() && !Auth::user()->hasRole('RECRUITER'))
                                                    <td> {{ $alumni->email }} </td>
                                                    <td> {{ $alumni->mobile }} </td>
                                                @endif
                                                <td> {{ $alumni->age }} </td>
                                                <td> {{ $alumni->category->name ?? '' }} </td>
                                                <td> {{ $alumni->cmot_edition }} </td>
                                                @if (Auth::check() && Auth::user()->hasRole('RECRUITER'))
                                                    <td>
                                                        {{-- @can('illuminae') --}}
                                                        {{-- @if ($illum::exists($illum->id)) --}}
                                                        <a id="not-interested-button" class="btn btn-sm btn-primary"
                                                            href="{{ route('alumni.notInterested', $alumni->id) }}">
                                                            Not-Interested
                                                        </a>
                                                        {{-- @else --}}
                                                        <a id="interested-button" class="btn btn-sm btn-primary"
                                                            href="{{ route('alumni.interested', $alumni->id) }}">
                                                            Interested
                                                        </a>
                                                        {{-- @endif --}}
                                                        {{-- @endcan --}}
                                                    </td>
                                                @endif

                                                <td>
                                                    @can('view')
                                                        <a class="btn btn-sm btn-info"
                                                            href="{{ route('alumnis.show', $alumni->id) }}">View</a>
                                                    @endcan
                                                    @can('delete')
                                                        <form action="{{ route('alumnis.destroy', $alumni->id) }}"
                                                            method="post" style="display: inline"
                                                            onsubmit="return confirmDelete()">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                        </form>
                                                    @endcan
                                                </td>
                                            </tr>

                                        @empty

                                            <td colspan="3">
                                                <span class="text-danger">
                                                    <strong>No illuminae Found!</strong>
                                                </span>
                                            </td>
                                        @endforelse

                                    </tbody>
                                @else
                                    <p>No record found...!!</p>
                                @endif

                            </table>
                        </div>

                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $alumnis->withQueryString()->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const notInterestedButton = document.getElementById('not-interested-button');
        notInterestedButton.addEventListener('click', function(event) {
            event.preventDefault();
            notInterestedButton.innerHTML = 'Not Interested ✗';
            notInterestedButton.classList.remove('btn-primary');
            notInterestedButton.classList.add('btn-danger');
            notInterestedButton.disabled = true;
            window.location.href = notInterestedButton.href;
        });
        const interestedButton = document.getElementById('interested-button');
        interestedButton.addEventListener('click', function(event) {
            event.preventDefault();
            interestedButton.innerHTML = 'Interested ✓';
            interestedButton.classList.remove('btn-primary');
            interestedButton.classList.add('btn-success');
            interestedButton.disabled = true;
            window.location.href = interestedButton.href;
        });
    });
</script>
