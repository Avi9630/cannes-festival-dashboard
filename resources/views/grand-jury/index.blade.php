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
                                            @can('assign')
                                                <th>Assign</th>
                                            @endcan
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
                                                @php
                                                    // dd($entry);
                                                @endphp
                                                @can('assign')
                                                    <td>
                                                        @if ($entry->stage === 3)
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
                                                            <form action="{{ url('assign-to-level2', $entry->id) }}" method="POST">
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
                                                        @elseif($entry->stage === 4)
                                                            <p style="color: blueviolet">Assigned to Level2</p>
                                                        @elseif($entry->stage === 5)
                                                            <p style="color: blueviolet">Score submitted by Level2</p>
                                                        @endif
                                                    </td>
                                                @endcan

                                                {{-- <td>
                                                    @if ($entry->stage === 3)
                                                        <button class="btn btn-sm btn-info" disabled>Selected</button>
                                                    @endif
                                                </td> --}}
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
@endsection
