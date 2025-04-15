@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            @if (Auth::user()->hasAnyRole(['SUPERADMIN', 'ADMIN']))
                <div class="col-md-12 col-sm-12 d-flex">
                    <div class="card card-animate w-100 ">
                        <div class="card-header">
                            <h4 class="card-title mb-0">CANNES ENTRY</h4>
                        </div>
                        <div class="card-body">
                            {{-- <div class="avatar-sm mb-1">
                                <div class="avatar-title bg-soft-success text-success fs-17 rounded">
                                    <i class="ri-flag-2-line"></i>
                                </div>
                            </div> --}}
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
                                            <span class="badge text-bg-primary">
                                                {{ isset($totalEntries) && !empty($totalEntries) ? $totalEntries : '' }}
                                            </span>
                                        </div>
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total assigned to jury</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span class="badge text-bg-primary">
                                                {{ isset($totalAssignedToJury) && !empty($totalAssignedToJury) ? $totalAssignedToJury : '' }}
                                            </span>
                                        </div>
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total scored by Jury</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ">
                                            <span class="badge text-bg-primary">
                                                {{ isset($totalScoreByJury) && !empty($totalScoreByJury) ? $totalScoreByJury : '' }}
                                            </span>
                                        </div>
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total selected by Grandjury </h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ">
                                            <span class="badge text-bg-primary">
                                                {{ isset($totalSelectByGrandJury) && !empty($totalSelectByGrandJury) ? $totalSelectByGrandJury : '' }}
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-12">
                    <div style="height: 400px; width: 100%;">
                        <canvas id="paymentChart"></canvas>
                    </div>
                </div>
                <div class="col-md-2"></div>
            @elseif(Auth::user()->hasRole('JURY'))
                <div class="col-md-12 col-sm-12 d-flex">
                    <div class="card card-animate w-100 ">
                        <div class="card-header">
                            <h4 class="card-title mb-0">CANNES ENTRY</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-group border-none mb-1">
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total assigned</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ">
                                            <span class="badge text-bg-primary">
                                                {{ isset($totalAssign) && !empty($totalAssign) ? $totalAssign : '' }}
                                            </span>
                                        </div>
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total pending by you </h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ">
                                            <span class="badge text-bg-primary">
                                                {{ isset($pendingByYou) && !empty($pendingByYou) ? $pendingByYou : '' }}
                                            </span>
                                        </div>
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total scored by you </h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ">
                                            <span class="badge text-bg-primary">
                                                {{ isset($scoreByYou) && !empty($scoreByYou) ? $scoreByYou : '' }}
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-12">
                    <div style="height: 400px; width: 100%;">
                        <canvas id="paymentChartJury"></canvas>
                    </div>
                </div>
                <div class="col-md-2"></div>
            @elseif(Auth::user()->hasRole('GRANDJURY'))
                <div class="col-md-12 col-sm-12 d-flex">
                    <div class="card card-animate w-100 ">
                        <div class="card-header">
                            <h4 class="card-title mb-0">CANNES ENTRY</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-group border-none mb-1">
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total scored by Jury</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ">
                                            <span class="badge text-bg-primary">
                                                {{ isset($totalScoreByJury) && !empty($totalScoreByJury) ? $totalScoreByJury : '' }}
                                            </span>
                                        </div>
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total selected by you </h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ">
                                            <span class="badge text-bg-primary">
                                                {{ isset($totalSelectByGrandJury) && !empty($totalSelectByGrandJury) ? $totalSelectByGrandJury : '' }}
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-12">
                    <div style="height: 400px; width: 100%;">
                        <canvas id="paymentChartGrandJury"></canvas>
                    </div>
                </div>
                <div class="col-md-2"></div>
            @else
                <h1>You don't have access to see this dashboard....</h1>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- SUPERADMIN-ADMIN --}}
    <script>
        const ctx = document.getElementById('paymentChart').getContext('2d');
        const paymentChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    'Total Entries',
                    'Total Assigned To Jury',
                    'Total Scored By Jury',
                    'Total Selected By Grand Jury'
                ],
                datasets: [{
                    label: 'Entry Status',
                    data: [
                        {{ $totalEntries ?? 0 }},
                        {{ $totalAssignedToJury ?? 0 }},
                        {{ $totalScoreByJury ?? 0 }},
                        {{ $totalSelectByGrandJury ?? 0 }}
                    ],
                    backgroundColor: [
                        '#007bff',
                        '#ffc107',
                        '#28a745',
                        '#dc3545'
                    ],
                    borderColor: [
                        '#ffffff',
                        '#ffffff',
                        '#ffffff',
                        '#ffffff'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Festival Entry Status'
                    }
                }
            }
        });
    </script>
    {{-- GRAND-JURY --}}
    <script>
        const ctx = document.getElementById('paymentChartGrandJury').getContext('2d');
        const paymentChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    'Total Scored By Jury',
                    'Total Selected By Grand Jury'
                ],
                datasets: [{
                    label: 'Entry Status',
                    data: [
                        {{ $totalScoreByJury ?? 0 }},
                        {{ $totalSelectByGrandJury ?? 0 }}
                    ],
                    backgroundColor: [
                        '#28a745', // Green for Scored
                        '#dc3545' // Red for Selected
                    ],
                    borderColor: [
                        '#ffffff',
                        '#ffffff'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Festival Entry Status'
                    }
                }
            }
        });
    </script>
    {{-- JURY --}}

    <script>
        const ctx = document.getElementById('paymentChartJury').getContext('2d');
        const paymentChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    // 'Total Entries',
                    'Total Assigned',
                    'Total pending by you',
                    'Total scored by you'
                ],
                datasets: [{
                    label: 'Entry Status',
                    data: [
                        {{ $totalAssign ?? 0 }},
                        {{ $pendingByYou ?? 0 }},
                        {{ $scoreByYou ?? 0 }},
                        // {{ $totalSelectByGrandJury ?? 0 }}
                    ],
                    backgroundColor: [
                        '#007bff',
                        '#ffc107',
                        '#28a745',
                        // '#dc3545'
                    ],
                    borderColor: [
                        '#ffffff',
                        '#ffffff',
                        '#ffffff',
                        // '#ffffff'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Festival Entry Status'
                    }
                }
            }
        });
    </script>
@endsection
