@extends('src.pages.master')

@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header"></div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <!-- Left side: Products and Cart -->
                    <div class="col-lg-8">
                        <!-- Search Bar -->
                        <div class="card mb-3 shadow-sm border-0">
                            <div class="card-body p-2">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                                    <input type="text" class="form-control border-start-0" placeholder="Search products or scan barcode..." data-bs-toggle="modal" data-bs-target="#searchProductModal" readonly style="cursor: pointer;">
                                    <span class="input-group-text bg-white border-start-0"><i class="bi bi-upc-scan"></i></span>
                                </div>
                            </div>
                        </div>

                        <!-- Cart Table -->
                        <div class="card shadow-sm border-0 mb-4 mb-lg-0">
                            <div class="card-body p-0">
                                <div class="table-responsive" style="min-height: 400px;">
                                    <table class="table table-hover mb-0 align-middle">
                                        <thead class="table-light text-muted small text-uppercase">
                                            <tr>
                                                <th class="ps-3 border-0 py-3">Item</th>
                                                <th class="text-center border-0 py-3" style="width: 150px;">Qty</th>
                                                <th class="text-end border-0 py-3">Price</th>
                                                <th class="text-end pe-3 border-0 py-3">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="ps-3 fw-medium">Whole Milk 2L</td>
                                                <td>
                                                    <div class="input-group input-group-sm justify-content-center">
                                                        <button class="btn btn-outline-secondary" type="button">-</button>
                                                        <input type="text" class="form-control text-center bg-white border-secondary" value="1" readonly style="max-width: 50px;">
                                                        <button class="btn btn-outline-secondary" type="button">+</button>
                                                    </div>
                                                </td>
                                                <td class="text-end text-muted">Rp4.50</td>
                                                <td class="text-end pe-3 fw-semibold">Rp4.50</td>
                                            </tr>
                                            <tr>
                                                <td class="ps-3 fw-medium">Sourdough Loaf</td>
                                                <td>
                                                    <div class="input-group input-group-sm justify-content-center">
                                                        <button class="btn btn-outline-secondary" type="button">-</button>
                                                        <input type="text" class="form-control text-center bg-white border-secondary" value="2" readonly style="max-width: 50px;">
                                                        <button class="btn btn-outline-secondary" type="button">+</button>
                                                    </div>
                                                </td>
                                                <td class="text-end text-muted">Rp6.25</td>
                                                <td class="text-end pe-3 fw-semibold">Rp12.50</td>
                                            </tr>
                                            <tr>
                                                <td class="ps-3 fw-medium">Fuji Apples (lb)</td>
                                                <td>
                                                    <div class="input-group input-group-sm justify-content-center">
                                                        <button class="btn btn-outline-secondary" type="button">-</button>
                                                        <input type="text" class="form-control text-center bg-white border-secondary" value="3.4" readonly style="max-width: 50px;">
                                                        <button class="btn btn-outline-secondary" type="button">+</button>
                                                    </div>
                                                </td>
                                                <td class="text-end text-muted">Rp1.99</td>
                                                <td class="text-end pe-3 fw-semibold">Rp6.77</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right side: Payment Details -->
                    <div class="col-lg-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body d-flex flex-column">
                                <!-- Customer Info -->
                                <div class="d-flex justify-content-between align-items-center mb-4 p-3 border rounded border-success bg-success bg-opacity-10">
                                    <div>
                                        <small class="text-success fw-bold d-block text-uppercase mb-1">Customer</small>
                                        <span class="text-dark">Walk-in Customer</span>
                                    </div>
                                    <!-- <button class="btn btn-sm text-success fw-bold text-uppercase">Change</button> -->
                                </div>

                                <!-- Totals -->
                                <!-- <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Items Total</span>
                                    <span class="text-dark">Rp32.67</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3 border-bottom pb-3">
                                    <span class="text-muted">Tax (8%)</span>
                                    <span class="text-dark">Rp2.61</span>
                                </div> -->
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <span class="fs-5 fw-bold text-dark text-uppercase">Total</span>
                                    <span class="fs-1 fw-bold text-primary">Rp35.28</span>
                                </div>

                                <!-- Cash Received -->
                                <div class="mb-3">
                                    <label class="form-label text-muted small fw-bold mb-1 text-uppercase">Cash Received</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control bg-light border-0 text-end fs-5 p-3 text-dark" value="Rp50.00">
                                    </div>
                                </div>

                                <!-- Change Due -->
                                <div class="mb-4">
                                    <label class="form-label text-muted small fw-bold mb-1 text-uppercase">Change Due</label>
                                    <div class="p-3 bg-success bg-opacity-10 text-success text-end fs-5 fw-bold rounded">
                                        Rp14.72
                                    </div>
                                </div>

                                <!-- Process Button -->
                                <button class="btn btn-primary w-100 py-3 mt-4 fs-5 fw-bold d-flex justify-content-center align-items-center gap-2 text-uppercase rounded">
                                    <i class="bi bi-wallet2"></i> Process Payment
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>

    <!-- Search Product Modal -->
    <div class="modal fade" id="searchProductModal" tabindex="-1" aria-labelledby="searchProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white border-0">
                    <h5 class="modal-title" id="searchProductModalLabel"><i class="bi bi-search me-2"></i>Cari Produk</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="p-3 bg-light border-bottom">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" id="searchInputModal" class="form-control form-control-lg border-start-0 ps-0" placeholder="Ketik nama atau kode produk..." autocomplete="off">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle" id="productTableModal">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th class="ps-4 text-uppercase small text-muted">Kode</th>
                                    <th class="text-uppercase small text-muted">Nama Produk</th>
                                    <th class="text-uppercase small text-muted">Kategori</th>
                                    <th class="text-end text-uppercase small text-muted">Harga</th>
                                    <th class="text-center text-uppercase small text-muted">Stok</th>
                                    <th class="text-end pe-4 text-uppercase small text-muted">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($produk) && count($produk) > 0)
                                    @foreach($produk as $item)
                                        <tr class="product-row">
                                            <td class="ps-4 text-muted product-code">{{ $item->product_code ?? '-' }}</td>
                                            <td class="fw-medium product-name">{{ $item->name ?? '-' }}</td>
                                            <td class="product-category">
                                                <span class="badge bg-secondary">{{ $item->kategori ? $item->kategori->name : 'Uncategorized' }}</span>
                                            </td>
                                            <td class="text-end text-primary fw-semibold">Rp{{ isset($item->price_sell) ? number_format($item->price_sell, 0, ',', '.') : '0' }}</td>
                                            <td class="text-center">
                                                @if(isset($item->quantity) && $item->quantity > 0)
                                                    <span class="badge bg-success bg-opacity-10 text-success">{{ $item->quantity }}</span>
                                                @else
                                                    <span class="badge bg-danger bg-opacity-10 text-danger">Habis</span>
                                                @endif
                                            </td>
                                            <td class="text-end pe-4">
                                                <button class="btn btn-sm btn-primary rounded-pill px-3" {{ (isset($item->quantity) && $item->quantity <= 0) ? 'disabled' : '' }}>
                                                    <i class="bi bi-plus-lg"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">Tidak ada data produk.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchProductModal = document.getElementById('searchProductModal');
            const searchInputModal = document.getElementById('searchInputModal');
            const productTableModal = document.getElementById('productTableModal');
            
            if (searchProductModal && searchInputModal && productTableModal) {
                const rows = productTableModal.querySelectorAll('.product-row');

                // Focus input when modal opens
                searchProductModal.addEventListener('shown.bs.modal', function () {
                    searchInputModal.focus();
                });

                // Filter table rows based on input
                searchInputModal.addEventListener('input', function() {
                    const query = this.value.toLowerCase().trim();

                    rows.forEach(row => {
                        const codeElement = row.querySelector('.product-code');
                        const nameElement = row.querySelector('.product-name');
                        
                        const code = codeElement ? codeElement.textContent.toLowerCase() : '';
                        const name = nameElement ? nameElement.textContent.toLowerCase() : '';

                        if (code.includes(query) || name.includes(query)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }
        });
    </script>
@endsection
