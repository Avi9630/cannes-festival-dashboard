@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            @if (Auth::user()->hasAnyRole(['SUPERADMIN', 'ADMIN']))
                <div class="col-md-12 col-sm-12 d-flex">
                    <div class="card card-animate w-100 ">
                        <div class="card-header">
                            <h4 class="card-title mb-0">CANNES ENTRY</h4>
                        </div>
                        <div class="card-body">

                            <ul class="list-group border-none mb-1">

                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total entries</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span class="badge text-bg-primary">
                                                {{ isset($totalEntries) && !empty($totalEntries) ? $totalEntries : '' }}
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @elseif(Auth::user()->hasRole('JURY'))
                <div class="col-md-12 col-sm-12 d-flex">
                    <div class="card card-animate w-100 ">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Scores by you</h4>
                        </div>
                        <div class="card-body">
                            @if (isset($scoreByJury) && !empty($scoreByJury))
                                <table class="table custom-table">
                                    <thead>
                                        <tr>
                                            <th>Ref.No</th>
                                            <th>Cannes ID</th>
                                            <th>Jury Name</th>
                                            <th>Overall Score</th>
                                            <th>Feedback</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($scoreByJury as $key => $score)
                                            <tr>
                                                <td> {{ $score->id }} </td>
                                                <td> {{ $score->festival_entry_id }} </td>
                                                <td> {{ $score->user->name ?? '' }} </td>
                                                <td> {{ $score->overall_score ?? 'Pending By you' }} </td>
                                                <td> {{ $score->feedback ?? 'Pending By you' }} </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <h1>You don't have access to see this dashboard....</h1>
            @endif
        </div>
    </div>
@endsection
