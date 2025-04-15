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
                                            <th>Ref.No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Selected</th>
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
                                                    @if ($entry->stage === 3)
                                                        <button class="btn btn-sm btn-info" disabled>Selected</button>
                                                    @endif
                                                </td>
                                                <td>
                                                    @can('view')
                                                        @if ($entry->stage != 3)
                                                            <a href="{{ route('cannes-selected-view', $entry->id) }}">
                                                                <i class="ri-eye-fill black-text"></i>
                                                            </a>
                                                        @endif
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
