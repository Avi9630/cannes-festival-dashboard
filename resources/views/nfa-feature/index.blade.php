@extends('layouts.app')
@section('title')
    {{ 'NFA-FEATURE-LIST' }}
@endsection
@section('content')
    <div class="container-fluid">

        <div class="pt-4 mb-4 mb-lg-3 pb-lg-4">
            <div class="g-4">
                <div>
                    <form action="{{ route('nfa-feature-search') }}" method="GET" class="filter-project">@csrf
                        @method('GET')
                        <div class="row">

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label"><strong>From Date</strong></label>
                                    <input type="date" name="from_date" class="form-control"
                                        value="{{ isset($payload['from_date']) ? $payload['from_date'] : '' }}"
                                        placeholder="Please select date">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email"><strong>To Date</strong></label>
                                    <input type="date" name="to_date" class="form-control"
                                        value="{{ isset($payload['to_date']) ? $payload['to_date'] : '' }}"
                                        placeholder="Please select date">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="payment_status"><strong>Payment status</strong></label>
                                    <select name="payment_status" id="payment_status" class="form-select">
                                        <option value="">Select status</option>
                                        @foreach ($paids as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ isset($payload['payment_status']) && $payload['payment_status'] == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6" id="step-selection" style="display: none;">
                                <div class="mb-3">
                                    <label for="payment_status"><strong>Select steps</strong></label>
                                    <select name="step" class="form-select">
                                        <option value="">Select status</option>
                                        @foreach ($steps as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ isset($payload['step']) && $payload['step'] == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name" class="form-label w-100">&nbsp;</label>
                                <button type="submit" class="btn common-btn">SEARCH</button>
                                @can('ip-non_featured_download')
                                    <a href="{{ route('export.search') }}" class="btn common-btn">
                                        SEARCH-EXPORT</a>
                                @endcan
                            </div>
                        </div>
                    </form>

                    <div class="text-end">
                        <a href="{{ route('nfa-feature') }}" class="btn common-btn">RESET</a>
                        <a href="{{ route('nfa-feature-export') }}" class="btn common-btn">EXPORT-ALL </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 d-flex">
                <div class="card card-animate w-100 ">

                    <div class="card-header">
                        <h4 class="card-title mb-0 project-title">
                            NATIONAL FILM AWARD - FEATURE (COUNT :- {{ isset($count) ? $count : '' }})
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
                                @if (count($features) > 0)
                                    <thead>
                                        <tr>
                                            <th>PDF</th>
                                            <th>ZIP</th>
                                            <th>Movie Ref</th>
                                            <th>Steps</th>
                                            <th>Client Name</th>
                                            <th>Client Email</th>
                                            <th>Film Title in Roman</th>
                                            <th>Film Title in Devnagari</th>
                                            <th>Film Title English</th>
                                            <th>Language</th>
                                            <th>Payment Date & Time</th>
                                            <th>Payment Amount</th>
                                            <th>Payment Receipt No</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($features as $key => $feature)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('nfa-feature-pdf', ['id' => $feature->id]) }}"
                                                        class="text-danger" target="_blank">
                                                        <i class="ri-file-pdf-line"></i>
                                                    </a>
                                                </td>

                                                <td>
                                                    <a href="{{ route('nfa-feature-zip', ['id' => $feature->id]) }}"
                                                        class="text-danger"><i class="ri-folder-zip-line"></i>
                                                    </a>
                                                </td>

                                                <td> {{ $feature->id }} </td>

                                                <td>
                                                    @foreach ($feature::stepsFeature() as $key => $value)
                                                        {{ isset($feature->step) && $feature->step === $value ? ($key === 'SUBMISSION' ? 'PAID' : $key) : '' }}
                                                    @endforeach
                                                </td>

                                                @php
                                                    $fullName =
                                                        $feature->client->first_name .
                                                        ' ' .
                                                        $feature->client->last_name;
                                                @endphp

                                                <td>{{ $fullName ?? '' }}</td>

                                                <td>{{ $feature->client->email ?? '' }}</td>

                                                <td>{{ $feature->film_title_roman }}</td>

                                                <td>{{ $feature->film_title_devnagri }}</td>

                                                <td>{{ $feature->film_title_english }}</td>

                                                <td>{{ $feature->language ?? '' }}</td>

                                                @php
                                                    $payment = App\Models\Transaction::where([
                                                        'website_type' => 1,
                                                        'client_id' => $feature['client_id'],
                                                        'context_id' => $feature['id'],
                                                        'auth_status' => '0300',
                                                    ])->first();

                                                    if (!is_null($payment)) {
                                                        $paymentDate = $payment->payment_date;
                                                        $paymentAmount = $payment->amount;
                                                        $paymentReceipt = $payment->bank_ref_no;
                                                    } else {
                                                        $paymentDate = '';
                                                        $paymentAmount = '';
                                                        $paymentReceipt = '';
                                                    }
                                                @endphp
                                                <td>{{ $paymentDate ?? '' }}</td>
                                                <td>{{ $paymentAmount ?? '' }}</td>
                                                <td>{{ $paymentReceipt ?? '' }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                @else
                                    <p>No record found...!!</p>
                                @endif
                            </table>
                        </div>

                        <!-- Pagination -->
                        <nav aria-label="...">
                            <ul class="pagination">
                                {{ $features->withQueryString()->links() }}
                            </ul>
                        </nav>
                        <!-- Pagination End-->

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
