@extends('layouts.app')
@section('title')
    {{ 'BEST-BOOK-CINEMA-LIST' }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="pt-4 mb-4 mb-lg-3 pb-lg-4">
            <div class="g-4">
                <div>
                    <form action="{{ route('best-book-cinema-search') }}" method="GET" class="filter-project">@csrf
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
                                    <a href="{{ route('best-book-cinema-export-search') }}" class="btn common-btn">
                                        SEARCH-EXPORT
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </form>

                    <div class="text-end">
                        <a href="{{ route('best-book-cinema') }}" class="btn common-btn">RESET</a>
                        <a href="{{ route('best-book-cinema-export-all') }}" class="btn common-btn">
                            EXPORT-ALL
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 d-flex">
                <div class="card card-animate w-100 ">

                    <div class="card-header">
                        <h4 class="card-title mb-0 project-title">
                            BEST BOOK CINEMA (COUNT :- {{ isset($count) ? $count : '' }})
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
                                @if (count($bestBookCinemas) > 0)
                                    <thead>
                                        <tr>
                                            <th>PDF</th>
                                            <th>ZIP</th>
                                            <th>Movie Ref</th>
                                            <th>Steps</th>
                                            <th>Client Name</th>
                                            <th>Client Email</th>
                                            <th>Author Name</th>
                                            <th>Author Contact</th>
                                            <th>Author Address</th>
                                            <th>Author Nationality</th>
                                            <th>Payment Date & Time</th>
                                            <th>Payment Amount</th>
                                            <th>Payment Receipt No</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bestBookCinemas as $key => $bestBookCinema)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('ip.pdf', ['id' => $bestBookCinema->id]) }}"
                                                        class="text-danger" target="_blank">
                                                        <i class="ri-file-pdf-line"></i>
                                                    </a>
                                                </td>

                                                <td>
                                                    <a href="{{ route('ip.zip', ['id' => $bestBookCinema->id]) }}"
                                                        class="text-danger"><i class="ri-folder-zip-line"></i>
                                                    </a>
                                                </td>

                                                <td> {{ $bestBookCinema->id }} </td>

                                                <td>
                                                    @foreach ($bestBookCinema::stepsBestBook() as $key => $value)
                                                        {{ isset($bestBookCinema->step) && $bestBookCinema->step === $value ? ($key === 'SUBMISSION' ? 'PAID' : $key) : '' }}
                                                    @endforeach
                                                </td>

                                                @php
                                                    $fullName =
                                                        $bestBookCinema->client->first_name .
                                                        ' ' .
                                                        $bestBookCinema->client->last_name;
                                                @endphp

                                                <td>{{ $fullName ?? '' }}</td>

                                                <td>{{ $bestBookCinema->client->email ?? '' }}</td>

                                                <td>{{ $bestBookCinema->author_name }}</td>

                                                <td>{{ $bestBookCinema->author_contact }}</td>

                                                <td>{{ $bestBookCinema->author_address }}</td>

                                                <td>{{ $bestBookCinema->author_nationality_indian === 1 ? 'Indian' : null }}
                                                </td>

                                                @php
                                                    $payment = App\Models\Transaction::where([
                                                        'website_type' => 1,
                                                        'client_id' => $bestBookCinema['client_id'],
                                                        'context_id' => $bestBookCinema['id'],
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
                                {{ $bestBookCinemas->withQueryString()->links() }}
                            </ul>
                        </nav>
                        <!-- Pagination End-->

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
