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
                                <a href="{{ route('cannes-entries-list') }}" class="btn btn-sm btn-warning">&larr; Back</a>
                            </div>
                            <h4 class="card-title">PREVIEW</h4>
                        </div>

                        <div class="card-body">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row pt-2">

                                        <div class="col-md-4">
                                            <p><strong>Full Name : </strong> {{ $festival->NAME ?? '' }}</p>
                                        </div>

                                        @if (Auth::check() && !Auth::user()->hasRole('RECRUITER'))
                                            <div class="col-md-4">
                                                <p><strong>Email : </strong> {{ $festival->email ?? '' }}</p>
                                            </div>

                                            <div class="col-md-4">
                                                <p><strong>Mobile : </strong> {{ $festival->mobile ?? '' }}</p>
                                            </div>
                                        @endif

                                        <div class="col-md-4">
                                            <p><strong>Film Title : </strong> {{ $festival->film_title ?? '' }}</p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Film Title English : </strong>
                                                {{ $festival->film_title_english ?? '' }}</p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Language : </strong> {{ $festival->LANGUAGE ?? '' }}</p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Producer Name : </strong> {{ $festival->producer_name ?? '' }}</p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Producetion Company : </strong>
                                                {{ $festival->production_company ?? '' }}</p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Screener Link : </strong> {{ $festival->screener_link ?? '' }}</p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Film Link : </strong>
                                                <a href="{{ $festival->film_link ?? '' }}"
                                                    target="_blank">{{ $festival->film_link ?? '' }}
                                                </a>
                                            </p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Password : </strong> {{ $festival->PASSWORD ?? '' }}</p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Director Name : </strong> {{ $festival->director_name ?? '' }}</p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Synopsis : </strong> {{ $festival->synopsis ?? '' }}</p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Director Bio : </strong> {{ $festival->director_bio ?? '' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex" style="margin-left:400px; margin-top: 15px;">
                                @if (Auth::check() && Auth::user()->hasRole('JURY'))
                                    <a href="{{ url('score-by', $festival->id) }}" class="btn btn-primary"
                                        style="margin-right: 5px;">
                                        Submit your score
                                    </a>
                                @endif
                            </div>
                        </div>
                        <br>
                    </div>
                    {{-- LEVEL-1 --}}
                    @if ((Auth::check() && Auth::user()->hasRole('SUPERADMIN')) || Auth::user()->hasRole('ADMIN'))
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">LEVEL SCORES</h4>
                            </div>
                            <div class="card-body">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row pt-2">
                                            @if (isset($juryScores) && !empty($juryScores) && count($juryScores) > 0)
                                                <table class="table custom-table">
                                                    <thead>
                                                        <tr>
                                                            {{-- <th>Ref.No</th> --}}
                                                            <th>Jury Name</th>
                                                            <th>Overall Score</th>
                                                            <th>Feedback</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($juryScores as $key => $score)
                                                            <tr>
                                                                {{-- <td> {{ $score->id }} </td> --}}
                                                                <td> {{ $score->user->name ?? '' }} </td>
                                                                <td> {{ $score->overall_score ?? '' }} </td>
                                                                <td> {{ $score->feedback ?? '' }} </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @else
                                                <p>Marks not given by Level1.!!</p>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    {{-- LEVEL-2 --}}
                    @if ((Auth::check() && Auth::user()->hasRole('SUPERADMIN')) || Auth::user()->hasRole('ADMIN'))
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">LEVEL2 SCORES</h4>
                            </div>
                            <div class="card-body">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row pt-2">
                                            @if (isset($level2Scores) && !empty($level2Scores) && count($level2Scores) > 0)
                                                <table class="table custom-table">
                                                    <thead>
                                                        <tr>
                                                            {{-- <th>Ref.No</th> --}}
                                                            <th>Jury Name</th>
                                                            <th>Overall Score</th>
                                                            <th>Feedback</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($level2Scores as $key => $score)
                                                            <tr>
                                                                {{-- <td> {{ $score->id }} </td> --}}
                                                                <td> {{ $score->user->name ?? '' }} </td>
                                                                <td> {{ $score->overall_score ?? '' }} </td>
                                                                <td> {{ $score->feedback ?? '' }} </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @else
                                                <p>Marks not given by Level2.!!</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
