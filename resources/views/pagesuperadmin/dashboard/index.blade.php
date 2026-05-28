@extends('template-admin.layout')

@section('content')
<div class="pc-container">
    <div class="pc-content">

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-superadmin') }}">Home</a></li>
                            <li class="breadcrumb-item" aria-current="page">Dashboard</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Dashboard Superadmin</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white"
                            style="width:56px;height:56px;background:linear-gradient(135deg,#4f46e5,#7c3aed);flex-shrink:0;">
                            <i class="fas fa-users fa-lg"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Total Jemaah Terdaftar</p>
                            <h3 class="mb-0 fw-bold">{{ $pelanggan }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white"
                            style="width:56px;height:56px;background:linear-gradient(135deg,#0ea5e9,#0284c7);flex-shrink:0;">
                            <i class="fas fa-mars fa-lg"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Laki-laki</p>
                            <h3 class="mb-0 fw-bold">{{ $lakiLaki }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white"
                            style="width:56px;height:56px;background:linear-gradient(135deg,#ec4899,#db2777);flex-shrink:0;">
                            <i class="fas fa-venus fa-lg"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Perempuan</p>
                            <h3 class="mb-0 fw-bold">{{ $perempuan }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white"
                            style="width:56px;height:56px;background:linear-gradient(135deg,#f59e0b,#d97706);flex-shrink:0;">
                            <i class="fas fa-calendar-alt fa-lg"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Pendaftar Tahun Ini</p>
                            <h3 class="mb-0 fw-bold">{{ end($yearData) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 1: Tren Tahunan (full width) -->
        <div class="row g-3 mb-3">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom-0 pb-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="mb-1 fw-bold">
                                    <i class="fas fa-chart-bar me-2 text-primary"></i>
                                    Tren Pendaftar Calon Jemaah per Tahun
                                </h5>
                                <p class="text-muted small mb-0">
                                    Data {{ $yearLabels[0] }} &ndash; {{ end($yearLabels) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="height:280px;">
                        <canvas id="chartTahunan"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 2: Usia + Jenis Kelamin -->
        <div class="row g-3 mb-4">
            <!-- Chart Distribusi Usia -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom-0 pb-0">
                        <h5 class="mb-1 fw-bold">
                            <i class="fas fa-chart-area me-2" style="color:#7c3aed;"></i>
                            Distribusi Usia Jemaah
                        </h5>
                        <p class="text-muted small mb-0">Berdasarkan kelompok umur</p>
                    </div>
                    <div class="card-body" style="height:280px;">
                        <canvas id="chartUsia"></canvas>
                    </div>
                </div>
            </div>

            <!-- Chart Jenis Kelamin -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom-0 pb-0">
                        <h5 class="mb-1 fw-bold">
                            <i class="fas fa-venus-mars me-2" style="color:#db2777;"></i>
                            Distribusi Jenis Kelamin
                        </h5>
                        <p class="text-muted small mb-0">Komposisi jemaah terdaftar</p>
                    </div>
                    <div class="card-body d-flex flex-column align-items-center justify-content-center" style="height:280px;">
                        <canvas id="chartJenisKelamin"></canvas>
                        <!-- Legend Manual -->
                        <div class="d-flex gap-4 mt-3 flex-wrap justify-content-center">
                            <div class="d-flex align-items-center gap-2">
                                <span style="width:14px;height:14px;border-radius:3px;background:#0ea5e9;display:inline-block;"></span>
                                <span class="small">Laki-laki <strong>{{ $lakiLaki }}</strong></span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span style="width:14px;height:14px;border-radius:3px;background:#ec4899;display:inline-block;"></span>
                                <span class="small">Perempuan <strong>{{ $perempuan }}</strong></span>
                            </div>
                            @if($belumIsi > 0)
                            <div class="d-flex align-items-center gap-2">
                                <span style="width:14px;height:14px;border-radius:3px;background:#d1d5db;display:inline-block;"></span>
                                <span class="small">Belum diisi <strong>{{ $belumIsi }}</strong></span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /pc-content -->
</div><!-- /pc-container -->

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    // =====================
    // Data dari PHP/Blade
    // =====================
    const usiaLabels  = @json($usiaLabels);
    const usiaData    = @json($usiaData);

    const jkLabels    = ['Laki-laki', 'Perempuan'@if($belumIsi > 0), 'Belum diisi'@endif];
    const jkData      = [{{ $lakiLaki }}, {{ $perempuan }}@if($belumIsi > 0), {{ $belumIsi }}@endif];

    const yearLabels  = @json($yearLabels);
    const yearData    = @json($yearData);

    // =====================
    // Helper: gradient fill
    // =====================
    function makeGradient(ctx, color1, color2) {
        const gradient = ctx.createLinearGradient(0, 0, 0, 250);
        gradient.addColorStop(0, color1);
        gradient.addColorStop(1, color2);
        return gradient;
    }

    Chart.defaults.font.family = "'Segoe UI', system-ui, sans-serif";

    // =====================
    // Chart 1: Tren Tahunan (Bar)
    // =====================
    const ctxTahunan = document.getElementById('chartTahunan').getContext('2d');
    const gradTahunan = makeGradient(ctxTahunan, 'rgba(79,70,229,0.85)', 'rgba(79,70,229,0.2)');
    new Chart(ctxTahunan, {
        type: 'bar',
        data: {
            labels: yearLabels,
            datasets: [{
                label: 'Jumlah Pendaftar',
                data: yearData,
                backgroundColor: yearLabels.map((_, i) =>
                    i === yearLabels.length - 1 ? 'rgba(79,70,229,1)' : 'rgba(79,70,229,0.55)'
                ),
                borderColor: 'rgba(79,70,229,1)',
                borderWidth: 1,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.parsed.y} pendaftar`
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 13, weight: '600' } }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        stepSize: 1,
                    },
                    grid: { color: 'rgba(0,0,0,0.06)' }
                }
            }
        }
    });

    // =====================
    // Chart 2: Distribusi Usia (Bar horizontal)
    // =====================
    const ctxUsia = document.getElementById('chartUsia').getContext('2d');
    new Chart(ctxUsia, {
        type: 'bar',
        data: {
            labels: usiaLabels,
            datasets: [{
                label: 'Jumlah Jemaah',
                data: usiaData,
                backgroundColor: [
                    'rgba(99,102,241,0.8)',
                    'rgba(139,92,246,0.8)',
                    'rgba(167,139,250,0.8)',
                    'rgba(196,181,253,0.8)',
                    'rgba(224,231,255,0.9)',
                    'rgba(79,70,229,0.85)',
                ],
                borderColor: 'transparent',
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.parsed.x} jemaah`
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: { precision: 0, stepSize: 1 },
                    grid: { color: 'rgba(0,0,0,0.06)' }
                },
                y: {
                    grid: { display: false },
                    ticks: { font: { size: 12, weight: '600' } }
                }
            }
        }
    });

    // =====================
    // Chart 3: Jenis Kelamin (Doughnut)
    // =====================
    const ctxJK = document.getElementById('chartJenisKelamin').getContext('2d');
    new Chart(ctxJK, {
        type: 'doughnut',
        data: {
            labels: jkLabels,
            datasets: [{
                data: jkData,
                backgroundColor: [
                    'rgba(14,165,233,0.9)',
                    'rgba(236,72,153,0.9)',
                    'rgba(209,213,219,0.9)',
                ],
                borderColor: '#fff',
                borderWidth: 3,
                hoverOffset: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '68%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.label}: ${ctx.parsed} orang`
                    }
                }
            }
        }
    });
</script>
@endsection
