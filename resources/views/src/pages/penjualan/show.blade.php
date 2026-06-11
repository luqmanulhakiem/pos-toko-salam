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
                        <h3 class="mb-0">Rincian Nota</h3>
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
                    <div class="col-md-8 col-lg-6 mx-auto">
                        <div class="card shadow-sm border-0 rounded-4 mb-4">
                            <div class="card-header bg-white border-0 pt-4 pb-0 text-end">
                                <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-secondary me-2"><i class="bi bi-arrow-left"></i> Kembali</a>
                                <button onclick="window.print()" class="btn btn-sm btn-primary"><i class="bi bi-printer"></i> Cetak</button>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-4 p-md-5" id="print-area">
                                <div class="text-center mb-4">
                                    <h2 class="fw-bold mb-1 text-uppercase text-primary">Toko Salam</h2>
                                    <p class="text-muted mb-0 small">Struk Pembelian</p>
                                </div>
                                
                                <div class="border-top border-bottom border-2 border-dashed py-3 mb-4">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted small text-uppercase">No. Nota</span>
                                        <span class="fw-bold text-dark">{{ $penjualan->nota_id }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted small text-uppercase">Kasir</span>
                                        <span class="fw-semibold text-dark">{{ $penjualan->user->name }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted small text-uppercase">Waktu</span>
                                        <span class="fw-semibold text-dark">{{ \Carbon\Carbon::parse($penjualan->created_at)->timezone('Asia/Jakarta')->format('d/m/Y H:i') }}</span>
                                    </div>
                                </div>

                                <table class="table table-borderless mb-4">
                                    <thead class="border-bottom border-dark border-opacity-25">
                                        <tr>
                                            <th class="ps-0 py-2 text-uppercase small text-muted">Item</th>
                                            <th class="text-center py-2 text-uppercase small text-muted">Qty</th>
                                            <th class="text-end pe-0 py-2 text-uppercase small text-muted">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($nota) > 0)
                                            @foreach ($nota as $item)
                                                <tr>
                                                    <td class="ps-0 py-3 border-bottom border-light">
                                                        <div class="fw-bold text-dark">{{ $item->produk->name }}</div>
                                                        <div class="small text-muted">Rp{{ number_format($item->produk->price_sell, 0, ',', '.') }}</div>
                                                    </td>
                                                    <td class="text-center py-3 border-bottom border-light align-middle fw-semibold">{{ $item->quantity }}</td>
                                                    <td class="text-end pe-0 py-3 border-bottom border-light align-middle fw-bold text-dark">
                                                        Rp{{ number_format((float) $item->produk->price_sell * (int) $item->quantity, 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3" class="text-center py-5 text-muted">
                                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                                    Belum ada data
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>

                                <div class="border-top border-2 border-dashed pt-3 mt-2">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Total</span>
                                        <span class="fw-bold fs-5 text-primary">Rp{{ number_format($penjualan->grand_total, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Tunai</span>
                                        <span class="fw-semibold text-dark">Rp{{ number_format($penjualan->payment, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-4">
                                        <span class="text-muted">Kembalian</span>
                                        <span class="fw-semibold text-success">Rp{{ number_format($penjualan->charge, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <div class="text-center mt-5 p-3 bg-light rounded">
                                    <p class="fw-medium text-dark mb-1">Terima kasih atas kunjungan Anda!</p>
                                    <p class="small text-muted mb-0">Barang yang sudah dibeli tidak dapat ditukar/dikembalikan.</p>
                                </div>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        
                       <style>
                            .border-dashed {
                                border-style: dashed !important;
                            }
                            @media print {
                                @page {
                                    size: 50mm 180mm;
                                    margin: 0;
                                }
                                
                                /* Sembunyikan semua elemen di halaman web */
                                body * {
                                    visibility: hidden;
                                }
                                
                                /* Reset posisi body agar bersih tanpa margin bawaan browser */
                                body {
                                    margin: 0 !important;
                                    padding: 0 !important;
                                    background-color: #fff !important;
                                }
                                
                                /* Tampilkan kembali area struk dan anak-anaknya secara normal */
                                #print-area, #print-area * {
                                    visibility: visible;
                                    color: #000 !important;
                                }
                                
                                /* Posisikan struk tepat di tengah kertas ukuran 50mm menggunakan absolute & transform */
                                #print-area {
                                    position: absolute !important;
                                    top: 0 !important;
                                    left: 50% !important;
                                    transform: translateX(-50%) !important;
                                    width: 50mm !important;
                                    max-width: 50mm !important;
                                    padding: 4mm !important;
                                    font-size: 10px !important;
                                    box-sizing: border-box;
                                    margin: 0 !important;
                                }
                                
                                /* Sembunyikan total container layout agar tidak mengacaukan koordinat posisi absolute */
                                .app-main, .app-content, .container-fluid, .row, .col-md-8, .col-lg-6, .card {
                                    position: static !important;
                                    transform: none !important;
                                    margin: 0 !important;
                                    padding: 0 !important;
                                    border: none !important;
                                    box-shadow: none !important;
                                }
                                
                                .app-content-header {
                                    display: none !important;
                                }
                                
                                .bg-light {
                                    background-color: transparent !important;
                                }
                                
                                /* Optimasi teks & tabel agar pas di kertas thermal 50mm */
                                h2 {
                                    font-size: 13px !important;
                                    margin-top: 5px !important;
                                }
                                .fs-5 {
                                    font-size: 11px !important;
                                }
                                .small, small {
                                    font-size: 8.5px !important;
                                }
                                .table th, .table td {
                                    padding: 3px 0 !important;
                                    font-size: 9.5px !important;
                                }
                                .border-dashed {
                                    border-width: 1px !important;
                                }
                                .mb-4 {
                                    margin-bottom: 8px !important;
                                }
                                .mt-5 {
                                    margin-top: 12px !important;
                                }
                                .py-3 {
                                    padding-top: 4px !important;
                                    padding-bottom: 4px !important;
                                }
                                .p-4, .p-md-5 {
                                    padding: 0 !important; /* Reset padding bawaan card-body di layar */
                                }
                                .mt-2 {
                                    margin-top: 4px !important;
                                }
                                .pt-3 {
                                    padding-top: 6px !important;
                                }
                            }
                        </style>
                        
                        @if (request()->has('auto_print'))
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    // Give a slight delay to ensure rendering is complete before printing
                                    setTimeout(() => {
                                        window.print();
                                    }, 500);
                                });
                            </script>
                        @endif
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
