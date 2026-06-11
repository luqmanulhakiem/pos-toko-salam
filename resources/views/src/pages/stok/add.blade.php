@extends('src.pages.master')

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Tambah Stok</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('produk') }}">Produk</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Stok</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-content">
            <div class="container-fluid">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card card-primary card-outline mb-4">
                            <div class="card-header">
                                <div class="card-title">Tambah Stok</div>
                            </div>
                            <form action="{{ route('stok-flow.store') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                                <div>
                                                    @foreach ($errors->all() as $error)
                                                        <div>{{ $error }}</div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif
                                    <input type="hidden" name="type" value="masuk">
                                    <input type="hidden" name="produk_id" value="{{ $data->id }}">
                                    <div class="mb-3">
                                        <label for="nameInput" class="form-label">Nama Produk</label>
                                        <input type="text" value="{{ $data->name }}" class="form-control"
                                            id="nameInput" aria-describedby="emailHelp" disabled />
                                    </div>
                                    <div class="mb-3">
                                        <label for="nameInput" class="form-label">Stok Saat ini</label>
                                        <input type="text" value="{{ $data->stock }}" class="form-control"
                                            id="nameInput" aria-describedby="emailHelp" disabled />
                                    </div>
                                    <div class="mb-3">
                                        <label for="nameInput" class="form-label">Kuantitas</label>
                                        <input type="number" name="quantity" value="{{ old('quantity') }}"
                                            class="form-control" id="nameInput" aria-describedby="emailHelp" required />
                                    </div>
                                    <div class="mb-3">
                                        <label for="nameInput" class="form-label">Keterangan</label>
                                        <textarea class="form-control" name="description" id="nameInput" cols="30" rows="3"
                                            placeholder="Cth: Nama Distributor Barang">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
