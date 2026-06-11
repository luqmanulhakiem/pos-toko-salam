@extends('src.pages.master')

@section('content')
    <style>
        /* Change date input icon to black so it is visible */
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: brightness(0);
        }
    </style>
    @php 
        $type = Str::ucfirst(request('type')); 
    @endphp
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Laporan Stok Produk {{ $type }}</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Laporan Stok Produk {{ $type }}</li>
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
                <!--begin::Row-->
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-end align-items-center gap-2">
                                <form action="{{ route('stok-flow.report') }}" method="GET" class="d-flex align-items-center gap-2 m-0">
                                    @if(request()->has('type'))
                                        <input type="hidden" name="type" value="{{ request('type') }}">
                                    @endif
                                    <input type="date" name="start_date" class="form-control form-control-sm" value="{{ $startDate }}" required>
                                    <span>-</span>
                                    <input type="date" name="end_date" class="form-control form-control-sm" value="{{ $endDate }}" required>
                                    <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                                </form>
                                <a href="{{ route('stok-flow.exportPdf', ['start_date' => $startDate, 'end_date' => $endDate, 'type' => request('type')]) }}" class="btn btn-sm btn-success">Export</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Tanggal Transaksi</th>
                                            <th>Pengguna</th>
                                            <th>Nama Produk</th>
                                            <th>Harga Modal</th>
                                            <th>Harga Jual</th>
                                            <th>Stok</th>
                                            <th>Deskripsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($data) > 0)
                                            @foreach ($data as $item)
                                                <tr class="align-middle">
                                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Jakarta')->format('Y-m-d H:i:s') }}</td>
                                                    <td>{{ $item->user->name }}</td>
                                                    <td>{{ $item->produk->name }}</td>
                                                    <td>Rp. {{ number_format($item->cogs, 0, ',', '.') }}</td>
                                                    <td>Rp. {{ number_format($item->price_sell, 0, ',', '.') }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>{{ $item->description }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7" class="text-center">Belum ada data</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <ul class="pagination pagination-sm m-0 float-end">
                                    {!! $data->links() !!}
                                </ul>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
@endsection
