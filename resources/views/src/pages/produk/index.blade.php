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
                        <h3 class="mb-0">Produk</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Produk</li>
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
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <form action="{{ url()->current() }}" method="GET" class="w-100"
                                        style="max-width: 250px;">
                                        <div class="input-group">
                                            <input type="text" name="keyword" class="form-control" placeholder="Cari..."
                                                value="{{ request('keyword') }}">
                                            <button class="btn btn-outline-secondary" type="submit">
                                                <i class="bi bi-search"></i> </button>
                                        </div>
                                    </form>
                                    <div class="text-end">
                                        <a href="{{ route('produk.create') }}" class="btn btn-sm btn-primary">Tambah</a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Kode Produk</th>
                                            <th>Nama Produk</th>
                                            <th>Harga Modal</th>
                                            <th>Harga Jual</th>
                                            <th>Stok</th>
                                            <th style="width: 100px">Kelola Stok</th>
                                            <th style="width: 40px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($data) > 0)
                                            <?php $num = 1; ?>
                                            @foreach ($data as $item)
                                                <tr class="align-middle">
                                                    <td>{{ $num++ }}</td>
                                                    <td>{{ $item->product_code }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->cogs }}</td>
                                                    <td>{{ $item->price_sell }}</td>
                                                    <td>{{ $item->stock }}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="{{ route('stok-flow.decrease', $item->id) }}"
                                                                class="btn btn-sm btn-outline-primary">
                                                                <i class="bi bi-dash-circle"></i>
                                                            </a>
                                                            <a href="{{ route('stok-flow.add', $item->id) }}"
                                                                class="btn btn-sm btn-primary">
                                                                <i class="bi bi-plus-circle"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="{{ route('produk.edit', ['id' => $item->id]) }}"
                                                                class="btn btn-sm btn-warning">
                                                                <i class="bi bi-pencil-fill"></i>
                                                            </a>
                                                            <a href="{{ route('produk.delete', $item->id) }}"
                                                                class="btn btn-sm btn-danger" data-confirm-delete="true">
                                                                <i class="bi bi-trash-fill"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="8" class="text-center">Belum ada data</td>
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
