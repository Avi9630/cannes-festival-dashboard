@extends('layouts.app')
{{-- @section('title')
    {{ 'NFA-FEATURE-LIST' }} --}}
{{-- @endsection --}}
@section('content')
    <div class="container-fluid">

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
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($entries as $key => $entry)
                                            <tr>
                                                <td> {{ $entry->id }} </td>

                                                <td> {{ $entry->NAME ?? '' }} </td>

                                                <td>{{ $entry->email ?? '' }}</td>

                                                <td>{{ $entry->mobile ?? '' }}</td>

                                                <td>
                                                    {{-- @can('view') --}}
                                                        {{-- <a href="{{ route('cannes-level2-view', $entry->id) }}">
                                                            <i class="ri-eye-fill black-text"></i>
                                                        </a> --}}
                                                        @if (Auth::check() && Auth::user()->hasRole('JURY'))
                                                            <a href="{{ url('score-by-level2', $entry->id) }}"
                                                                class="btn btn-sm btn-primary" style="margin-right: 5px;">
                                                                Your Scors
                                                            </a>
                                                        @endif
                                                    {{-- @endcan --}}
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
                        {{-- <nav aria-label="...">
                            <ul class="pagination">
                                {{ $entries->withQueryString()->links() }}
                            </ul>
                        </nav> --}}
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
