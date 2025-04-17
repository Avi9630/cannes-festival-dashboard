@extends('layouts.app')
{{-- @section('title')
    {{ 'NFA-FEATURE-LIST' }} --}}
{{-- @endsection --}}
@section('content')
    <div class="container-fluid">

        @can('can-search')
            <div class="pt-4 mb-4 mb-lg-3 pb-lg-4">
                <div class="g-4">
                    <div>
                        <form action="{{ route('cannes-entries-search') }}" method="GET" class="filter-project">@csrf
                            @method('GET')
                            <div class="row">

                                @php
                                    $years = [
                                        1 => '2025',
                                        2 => '2024',
                                    ];
                                @endphp

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="year"><strong>Year</strong></label>
                                        <select name="year" class="form-select">
                                            <option value="">Select year</option>
                                            @foreach ($years as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ isset($payload['year']) && $payload['year'] == $key ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 from_date" id="fromDateField">
                                    <div class="mb-3">
                                        <label for="from_date" class="form-label"><strong>From Date</strong></label>
                                        {{-- <input type="date" name="from_date" class="form-control"
                                        value="{{ isset($payload['from_date']) ? $payload['from_date'] : '' }}"
                                        placeholder="Please select date"> --}}

                                        <input type="text" name="from_date" id="from_date" class="form-control"
                                            value="{{ isset($payload['from_date']) ? $payload['from_date'] : '' }}"
                                            placeholder="Please select date">
                                    </div>
                                </div>

                                <div class="col-md-6 to_date" id="toDateField">
                                    <div class="mb-3">
                                        <label for="email"><strong>To Date</strong></label>
                                        {{-- <input type="to_date" name="to_date" class="form-control"
                                        value="{{ isset($payload['to_date']) ? $payload['to_date'] : '' }}"
                                        placeholder="Please select date"> --}}

                                        <input type="text" name="to_date" id="to_date" class="form-control"
                                            value="{{ isset($payload['to_date']) ? $payload['to_date'] : '' }}"
                                            placeholder="Please select date">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <label for="name" class="form-label w-100">&nbsp;</label>
                                    <button type="submit" class="btn common-btn">SEARCH</button>
                                    @can('export-search')
                                        <a href="{{ route('export.cannes-search') }}" class="btn common-btn">
                                            SEARCH-EXPORT</a>
                                    @endcan
                                </div>
                            </div>
                        </form>

                        <div class="text-end">
                            <a href="{{ route('cannes-entries-list') }}" class="btn common-btn">RESET</a>
                            @can('export')
                                <a href="{{ route('cannes-entries-export') }}" class="btn common-btn">EXPORT-ALL </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        @endcan

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
                                            {{-- <th>PDF</th> --}}
                                            {{-- <th>ZIP</th> --}}
                                            <th>Ref.No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            @can('assign')
                                                <th>Assign</th>
                                            @endcan
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($entries as $key => $entry)
                                            <tr>
                                                {{-- <td>
                                                    <a href="{{ route('cannes-entries-pdf', ['id' => $entry->id]) }}"
                                                        class="text-danger" target="_blank">
                                                        <i class="ri-file-pdf-line"></i>
                                                    </a>
                                                </td> --}}

                                                {{-- <td>
                                                    <a href="{{ route('nfa-feature-zip', ['id' => $entry->id]) }}"
                                                        class="text-danger"><i class="ri-folder-zip-line"></i>
                                                    </a>
                                                </td> --}}

                                                <td> {{ $entry->id }} </td>

                                                <td> {{ $entry->NAME ?? '' }} </td>

                                                <td>{{ $entry->email ?? '' }}</td>

                                                <td>{{ $entry->mobile ?? '' }}</td>

                                                @can('assign')
                                                    <td>
                                                        @if ($entry->stage === 0 || $entry->stage === null)
                                                            @php
                                                                $juryRole = Spatie\Permission\Models\Role::where(
                                                                    'name',
                                                                    'jury',
                                                                )->first();
                                                                $users = App\Models\User::whereHas('roles', function (
                                                                    $query,
                                                                ) use ($juryRole) {
                                                                    $query->where('id', $juryRole->id);
                                                                })->get();
                                                            @endphp
                                                            <form action="{{ url('assign_to', $entry->id) }}" method="POST">
                                                                @csrf @method('POST')
                                                                <select name="user_id" id="user_id"
                                                                    class="form-select @error('user_id') is-invalid @enderror">
                                                                    <option value="" selected>Select Jury</option>
                                                                    @forelse ($users as $user)
                                                                        <option value="{{ $user->id }}"
                                                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                                            {{ $user->name }}</option>
                                                                        </option>
                                                                    @empty
                                                                    @endforelse
                                                                </select>
                                                                @error('user_id')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                                <button type="submit" id="submitButton"
                                                                    class="btn btn-sm btn-info">Assign</button>
                                                            </form>
                                                        @elseif($entry->stage === 1)
                                                            <p style="color: blueviolet">Assigned to Level1</p>
                                                        @elseif($entry->stage === 2)
                                                            <p style="color: blueviolet">Score submitted by Level1</p>
                                                        @elseif($entry->stage === 3)
                                                            <p style="color: blueviolet">Added to final selection list</p>
                                                        @elseif($entry->stage === 4)
                                                            <p style="color: blueviolet">Assigned to level2</p>
                                                        @elseif($entry->stage === 5)
                                                            <p style="color: blueviolet">Score submitted by level2</p>
                                                        @endif
                                                    </td>
                                                @endcan
                                                <td>
                                                    @can('view')
                                                        <a href="{{ route('cannes-entries.view', $entry->id) }}">
                                                            <i class="ri-eye-fill black-text"></i>
                                                        </a>
                                                    @endcan
                                                    {{-- @can('delete')
                                                        <form action="{{ route('cannes-entries.delete', $entry->id) }}"
                                                            method="post" style="display: inline"
                                                            onsubmit="return confirmDelete()">
                                                            @csrf @method('DELETE')
                                                            <button type="submit " class="deletebtn">
                                                                <i class="ri-delete-bin-fill "></i>
                                                            </button>
                                                        </form>
                                                    @endcan --}}
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <script>
        $(document).ready(function() {
            function toggleDateFields() {
                var selectedYear = $('select[name="year"]').val();
                if (selectedYear != '1') {
                    $('.from_date').hide();
                    $('.to_date').hide();
                } else {
                    $('.from_date').show();
                    $('.to_date').show();
                }
            }
            toggleDateFields();
            $('select[name="year"]').change(function() {
                toggleDateFields();
            });
        });
    </script>

    <script>
        $(function() {
            var minAllowedDate = new Date(2025, 0, 1);
            // Set up datepickers
            $("#from_date").datepicker({
                dateFormat: "yy-mm-dd",
                minDate: minAllowedDate,
                onClose: function(selectedDate) {
                    $("#to_date").datepicker("option", "minDate", selectedDate);
                }
            });

            $("#to_date").datepicker({
                dateFormat: "yy-mm-dd",
                onClose: function(selectedDate) {
                    $("#from_date").datepicker("option", "maxDate", selectedDate);
                }
            });
        });
    </script>


@endsection
