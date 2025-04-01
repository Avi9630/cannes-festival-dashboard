@extends('layouts.app')
@section('title')
    {{ 'NFA-FEATURE-LIST' }}
@endsection
@section('content')
    <div class="container-fluid">

        <div class="pt-4 mb-4 mb-lg-3 pb-lg-4">
            <div class="g-4">
                <div>
                    {{-- <form action="{{ route('nfa-feature-search') }}" method="GET" class="filter-project">@csrf
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
                    </form> --}}

                    {{-- <div class="text-end">
                        <a href="{{ route('nfa-feature') }}" class="btn common-btn">RESET</a>
                        <a href="{{ route('nfa-feature-export') }}" class="btn common-btn">EXPORT-ALL </a>
                    </div> --}}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 d-flex">
                <div class="card card-animate w-100 ">

                    <div class="card-header">
                        <h4 class="card-title mb-0 project-title">
                            CANNES ENTRIES (COUNT :- {{ isset($count) ? $count : '' }})
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
                                @if (count($entries) > 0)
                                    <thead>
                                        <tr>
                                            {{-- <th>PDF</th>
                                            <th>ZIP</th> --}}
                                            <th>Ref.No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Film Title</th>
                                            <th>Film Title English</th>
                                            <th>Language</th>
                                            {{-- <th>Producer Name</th>
                                            <th>Production Company</th>
                                            <th>Screener Link</th>
                                            <th>Film Link</th>
                                            <th>Paswword</th>
                                            <th>Director Name</th>
                                            <th>Synopsis</th>
                                            <th>Director Bio</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($entries as $key => $entry)
                                            <tr>
                                                {{-- <td>
                                                    <a href="{{ route('nfa-feature-pdf', ['id' => $entry->id]) }}"
                                                        class="text-danger" target="_blank">
                                                        <i class="ri-file-pdf-line"></i>
                                                    </a>
                                                </td>

                                                <td>
                                                    <a href="{{ route('nfa-feature-zip', ['id' => $entry->id]) }}"
                                                        class="text-danger"><i class="ri-folder-zip-line"></i>
                                                    </a>
                                                </td> --}}

                                                <td> {{ $entry->id }} </td>

                                                <td> {{ $entry->NAME ?? '' }} </td>

                                                <td>{{ $entry->email ?? '' }}</td>

                                                <td>{{ $entry->mobile ?? '' }}</td>

                                                <td>{{ $entry->film_title }}</td>

                                                <td>{{ $entry->film_title_english }}</td>

                                                <td>{{ $entry->LANGUAGE }}</td>

                                                {{-- <td>{{ $entry->producer_name ?? '' }}</td>

                                                <td>{{ $entry->production_company ?? '' }}</td>

                                                <td>{{ $entry->screener_link ?? '' }}</td>

                                                <td>{{ $entry->film_link ?? '' }}</td>

                                                <td>{{ $entry->PASSWORD ?? '' }}</td>

                                                <td>{{ $entry->director_name ?? '' }}</td>

                                                <td>{{ $entry->synopsis ?? '' }}</td>

                                                <td>{{ $entry->director_bio ?? '' }}</td> --}}
                                                <td>
                                                    @can('view')
                                                        <a href="{{ route('cannes-entries.view', $entry->id) }}">
                                                            <i class="ri-eye-fill black-text"></i>
                                                        </a>
                                                    @endcan
                                                    @can('delete')
                                                        <form action="{{ route('cannes-entries.delete', $entry->id) }}"
                                                            method="post" style="display: inline"
                                                            onsubmit="return confirmDelete()">
                                                            @csrf @method('DELETE')
                                                            <button type="submit " class="deletebtn">
                                                                <i class="ri-delete-bin-fill "></i>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </td>

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
                                {{ $entries->withQueryString()->links() }}
                            </ul>
                        </nav>
                        <!-- Pagination End-->

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
