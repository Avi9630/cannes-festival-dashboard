@extends('layouts.app')
@section('content')
    {{-- @livewire('counter') --}}
    <div class="container-fluid">
        <div class="row">
            @if (Auth::user()->hasAnyRole(['SUPERADMIN', 'ADMIN']))
                {{-- Feature Film Entry --}}
                <div class="col-md-4 col-sm-4 d-flex">
                    <div class="card card-animate w-100 ">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Feature Film Entry</h4>
                        </div>
                        <div class="card-body">
                            <div class="avatar-sm mb-1">
                                <div class="avatar-title bg-soft-success text-success fs-17 rounded">
                                    <i class="ri-flag-2-line"></i>
                                </div>
                            </div>
                            <ul class="list-group border-none mb-1">

                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total forms submitted</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span class="badge text-bg-primary">
                                                {{ isset($totalFeature) && !empty($totalFeature) ? $totalFeature : '' }}
                                            </span>
                                        </div>
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total paid </h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ">
                                            <span class="badge text-bg-primary">
                                                {{ isset($paidFeature) && !empty($paidFeature) ? $paidFeature : '' }}
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Non-Feature Film Entry --}}
                <div class="col-md-4 col-sm-4 d-flex">
                    <div class="card card-animate w-100 ">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Non-Feature Film Entry</h4>
                        </div>
                        <div class="card-body">
                            <div class="avatar-sm mb-1">
                                <div class="avatar-title bg-soft-success text-success fs-17 rounded">
                                    <i class="ri-flag-2-line"></i>
                                </div>
                            </div>
                            <ul class="list-group border-none mb-1">

                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total forms submitted</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span class="badge text-bg-primary">
                                                {{ isset($totalNonFeature) && !empty($totalNonFeature) ? $totalNonFeature : '' }}
                                            </span>
                                        </div>
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total paid </h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ">
                                            <span class="badge text-bg-primary">
                                                {{ isset($paidNonFeature) && !empty($paidNonFeature) ? $paidNonFeature : '' }}
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Best Book On Cinema --}}
                <div class="col-md-4 col-sm-4 d-flex">
                    <div class="card card-animate w-100 ">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Best Book On Cinema</h4>
                        </div>
                        <div class="card-body">
                            <div class="avatar-sm mb-1">
                                <div class="avatar-title bg-soft-warning text-warning fs-17 rounded">
                                    <i class="ri-folder-user-line"></i>
                                </div>
                            </div>
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
                                            {{-- <span class="badge text-bg-primary">{{ $totalEntries }}</span> --}}
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total completed</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            {{-- <span class="badge text-bg-primary">{{ $cmotCompleteForm }}</span> --}}
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Best Film Critic --}}
                <div class="col-md-4 col-sm-4 d-flex">
                    <div class="card card-animate w-100 ">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Best Book On Cinema</h4>
                        </div>
                        <div class="card-body">
                            <div class="avatar-sm mb-1">
                                <div class="avatar-title bg-soft-warning text-warning fs-17 rounded">
                                    <i class="ri-folder-user-line"></i>
                                </div>
                            </div>
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
                                            {{-- <span class="badge text-bg-primary">{{ $totalEntries }}</span> --}}
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total completed</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            {{-- <span class="badge text-bg-primary">{{ $cmotCompleteForm }}</span> --}}
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @elseif(Auth::user()->hasRole('PRODUCER'))
                {{-- Feature Film Entry --}}
                <div class="col-md-4 col-sm-4 d-flex">
                    <div class="card card-animate w-100 ">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Feature Film Entry</h4>
                        </div>
                        <div class="card-body">
                            <div class="avatar-sm mb-1">
                                <div class="avatar-title bg-soft-success text-success fs-17 rounded">
                                    <i class="ri-flag-2-line"></i>
                                </div>
                            </div>
                            <ul class="list-group border-none mb-1">

                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total forms submitted</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span class="badge text-bg-primary">
                                                {{ isset($totalFeature) && !empty($totalFeature) ? $totalFeature : '' }}
                                            </span>
                                        </div>
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total paid </h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ">
                                            <span class="badge text-bg-primary">
                                                {{ isset($paidFeature) && !empty($paidFeature) ? $paidFeature : '' }}
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Non-Feature Film Entry --}}
                <div class="col-md-4 col-sm-4 d-flex">
                    <div class="card card-animate w-100 ">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Non-Feature Film Entry</h4>
                        </div>
                        <div class="card-body">
                            <div class="avatar-sm mb-1">
                                <div class="avatar-title bg-soft-success text-success fs-17 rounded">
                                    <i class="ri-flag-2-line"></i>
                                </div>
                            </div>
                            <ul class="list-group border-none mb-1">

                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total forms submitted</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span class="badge text-bg-primary">
                                                {{ isset($totalNonFeature) && !empty($totalNonFeature) ? $totalNonFeature : '' }}
                                            </span>
                                        </div>
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total paid </h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ">
                                            <span class="badge text-bg-primary">
                                                {{ isset($paidNonFeature) && !empty($paidNonFeature) ? $paidNonFeature : '' }}
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @elseif(Auth::user()->hasAnyRole(['PUBLISHER']))
                {{-- Best Book On Cinema --}}
                <div class="col-md-4 col-sm-4 d-flex">
                    <div class="card card-animate w-100 ">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Best Book On Cinema</h4>
                        </div>
                        <div class="card-body">
                            <div class="avatar-sm mb-1">
                                <div class="avatar-title bg-soft-warning text-warning fs-17 rounded">
                                    <i class="ri-folder-user-line"></i>
                                </div>
                            </div>
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
                                            {{-- <span class="badge text-bg-primary">{{ $totalEntries }}</span> --}}
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total completed</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            {{-- <span class="badge text-bg-primary">{{ $cmotCompleteForm }}</span> --}}
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Best Film Critic --}}
                <div class="col-md-4 col-sm-4 d-flex">
                    <div class="card card-animate w-100 ">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Best Book On Cinema</h4>
                        </div>
                        <div class="card-body">
                            <div class="avatar-sm mb-1">
                                <div class="avatar-title bg-soft-warning text-warning fs-17 rounded">
                                    <i class="ri-folder-user-line"></i>
                                </div>
                            </div>
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
                                            {{-- <span class="badge text-bg-primary">{{ $totalEntries }}</span> --}}
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total completed</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            {{-- <span class="badge text-bg-primary">{{ $cmotCompleteForm }}</span> --}}
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @else
                <h1>You don't have access to see this dashboard....</h1>
            @endif
        </div>
    </div>
@endsection
