@extends('src.pages.master')

@section('content')
    <style>
        /* Change date input icon to black so it is visible */
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: brightness(0);
        }
    </style>
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Laporan Pengembalian Barang</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Laporan Pengembalian</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!--end::App Content Header-->
        
        <!--begin::App Content-->
        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-end align-items-center">
                                <form action="{{ route('pengembalian.report') }}" method="GET" class="d-flex align-items-center gap-2 m-0">
                                    <input type="date" name="start_date" class="form-control form-control-sm" value="{{ $startDate }}" required>
                                    <span>-</span>
                                    <input type="date" name="end_date" class="form-control form-control-sm" value="{{ $endDate }}" required>
                                    <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                                </form>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>No Nota</th>
                                            <th>Kasir</th>
                                            <th>Kode Produk</th>
                                            <th>Nama Produk</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($pengembalians && count($pengembalians) > 0)
                                            @foreach ($pengembalians as $item)
                                                <tr class="align-middle">
                                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Jakarta')->format('Y-m-d H:i:s') }}</td>
                                                    <td>{{ $item->no_nota }}</td>
                                                    <td>{{ $item->user->name ?? '-' }}</td>
                                                    <td>{{ $item->produk->product_code ?? '-' }}</td>
                                                    <td>{{ $item->produk->name ?? 'Produk Dihapus' }}</td>
                                                    <td><span class="badge text-bg-warning">{{ $item->quantity }}</span></td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center">Belum ada data pengembalian barang</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <ul class="pagination pagination-sm m-0 float-end">
                                    {!! $pengembalians->links() !!}
                                </ul>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </div>
        <!--end::App Content-->
    </main>
@endsection
