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
                            <br>

                            <form id="reviewForm" action="{{ url('score-by', $festival->id) }}" method="POST">
                                @csrf @method('POST')
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3 row">
                                                    <label for="name"
                                                        class="col-md-4 col-form-label text-md-end text-start">
                                                        <strong>Overall Score:-</strong>
                                                    </label>
                                                    <div class="col-md-6" style="line-height: 35px;">
                                                        <input type="text" name="overall_score" id="overall_score"
                                                            class="form-control @error('overall_score') is-invalid @enderror"
                                                            value="{{ old('overall_score') }}"
                                                            placeholder="Score should be 1 to 10 only" />
                                                        <span><strong>1</strong> (lowest), <strong>10</strong>
                                                            (Highest)</span>
                                                        @error('overall_score')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3 row">
                                                    <label for="name"
                                                        class="col-md-4 col-form-label text-md-end text-start"><strong>Feedback:</strong></label>
                                                    <div class="col-md-6" style="line-height: 35px;">
                                                        <input type="text" name="feedback" id="feedback"
                                                            value="{{ old('feedback') }}"
                                                            class="form-control @error('feedback') is-invalid @enderror"
                                                            placeholder="Feedback" />
                                                        @error('feedback')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-center">
                                                <button type="submit" class="btn btn-sm btn-info"
                                                    id="submitBtn">Submit</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </form>

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

                                        {{-- <div class="col-md-4">
                                            <p><strong>Additional Information : </strong>
                                                <a href="{{ $festival->additional_info ?? '' }}"
                                                    target="_blank">{{ $festival->additional_info ?? '' }}
                                                </a>
                                            </p>
                                        </div> --}}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('reviewForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const overall_score = document.getElementById('overall_score').value;
            const feedback = document.getElementById('feedback').value;

            if (overall_score === '' || !/^\d+$/.test(overall_score) || parseInt(overall_score, 10) > 10) {
                alert(overall_score === '' ? 'Overall score cannot be empty.' :
                    !/^\d+$/.test(overall_score) ? 'Overall score must contain only numbers.' :
                    'Overall score must be 10 or less.');
                return;
            }

            if (feedback === '') {
                alert('Feedback cannot be empty');
                return;
            }
            const wordCount = feedback.trim().split(/\s+/).filter(function(word) {
                return word.length > 0;
            }).length;

            if (wordCount > 200) {
                alert('Feedback must contain less than 200 words.');
                return;
            }

            const confirmed = confirm(
                "Are you sure you want to submit the form? After submitting, you will not score again!");
            if (confirmed) {
                this.submit();
            }
        });
    </script>
@endsection
