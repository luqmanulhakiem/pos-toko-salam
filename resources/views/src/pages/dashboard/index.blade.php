@extends('src.pages.master')

@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Dashboard</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Welcome Card-->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm rounded-4 text-white overflow-hidden" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);">
                            <div class="card-body p-4 position-relative">
                                <div class="row align-items-center">
                                    <div class="col-md-8 position-relative z-1">
                                        <h4 class="fw-bold mb-2">Selamat Datang kembali, {{ auth()->user()->name ?? 'Admin' }}! 👋</h4>
                                        <p class="mb-0 text-white-50">Berikut adalah ringkasan performa penjualan toko hari ini. Tetap semangat dan berikan pelayanan terbaik!</p>
                                    </div>
                                    <div class="col-md-4 text-end d-none d-md-block position-relative z-1">
                                        <i class="bi bi-basket text-white" style="font-size: 4rem; opacity: 0.8;"></i>
                                    </div>
                                </div>
                                <!-- Background decorative icon -->
                                <div class="position-absolute" style="top: -20px; right: -10px; font-size: 180px; opacity: 0.05; transform: rotate(-15deg); pointer-events: none;">
                                    <i class="bi bi-shop"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Welcome Card-->
                @role('admin')
                <!--begin::Row-->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box text-bg-primary">
                            <div class="inner">
                                <h3>Rp {{ number_format($grossRevenue, 0, ',', '.') }}</h3>
                                <p>Pendapatan Kotor
                                    <br>
                                    <span class="opacity-75">Bulan Ini</span>
                                </p>
                            </div>
                            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M12 7.5a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z"></path>
                                <path fill-rule="evenodd" d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v14.25c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 19.125V4.875zm11.25 2.625a3.75 3.75 0 10-7.5 0 3.75 3.75 0 007.5 0zm-5.25 7.5a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box text-bg-success">
                            <div class="inner">
                                <h3>Rp {{ number_format($netProfit, 0, ',', '.') }}</h3>
                                <p>Pendapatan Bersih
                                    <br>
                                    <span class="opacity-75">Bulan Ini</span>
                                </p>
                            </div>
                            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box text-bg-warning">
                            <div class="inner">
                                <h3>{{ number_format($totalPesanan, 0, ',', '.') }}</h3>
                                <p>Total Pesanan
                                    <br>
                                    <span class="opacity-75">Bulan Ini</span>
                                </p>
                            </div>
                            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box text-bg-danger">
                            <div class="inner">
                                <h3>{{ number_format($totalProdukTerjual, 0, ',', '.') }}</h3>
                                <p>Total Produk Terjual
                                    <br>
                                    <span class="opacity-75">Bulan Ini</span>
                                </p>
                            </div>
                            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-7 connectedSortable">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h3 class="card-title">Pertumbuhan Penjualan</h3>
                            </div>

                            <div class="card-body">
                                <div id="revenue-chart"></div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.Start col -->
                    <!-- Start col -->
                    <div class="col-lg-5 connectedSortable">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h3 class="card-title">Penjualan Terakhir</h3>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-striped align-middle">
                                    <thead>
                                        <tr>
                                            <th>Nota</th>
                                            <th>Kasir</th>
                                            <th>Total</th>
                                            <th>Waktu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentSales as $sale)
                                        <tr>
                                            <td>{{ $sale->nota_id }}</td>
                                            <td>{{ $sale->user->name ?? 'User' }}</td>
                                            <td>Rp {{ number_format($sale->grand_total, 0, ',', '.') }}</td>
                                            <td>{{ $sale->created_at->diffForHumans() }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Belum ada penjualan.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.Start col -->
                </div>
                <!-- /.row (main row) -->
                @endrole

            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
@endsection

@push('scripts')
    <script>
        const sales_chart_options = {
            series: [{
                    name: 'Bulan Ini',
                    data: @json($chartDataCurrent),
                },
                {
                    name: 'Bulan Kemarin',
                    data: @json($chartDataLast),
                },
            ],
            chart: {
                height: 300,
                type: 'area',
                toolbar: {
                    show: false,
                },
            },
            legend: {
                show: true,
            },
            colors: ['#0d6efd', '#adb5bd'],
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: 'smooth',
            },
            xaxis: {
                categories: @json($categories),
                title: {
                    text: 'Tanggal'
                }
            },
            yaxis: {
                title: {
                    text: 'Pendapatan (Rp)'
                },
                labels: {
                    formatter: function (val) {
                        return "Rp " + val.toLocaleString("id-ID");
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "Rp " + val.toLocaleString("id-ID");
                    }
                }
            },
        };

        const sales_chart = new ApexCharts(
            document.querySelector('#revenue-chart'),
            sales_chart_options,
        );
        sales_chart.render();
    </script>
@endpush
