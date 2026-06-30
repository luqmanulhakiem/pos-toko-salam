@extends('src.pages.master')

@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Pengembalian Barang</h3>
                    </div>
                </div>
            </div>
        </div>
        <!--end::App Content Header-->
        
        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <!-- Left side: Items Return Table -->
                    <div class="col-lg-8">
                        <!-- Search Bar -->
                        <div class="card mb-3 shadow-sm border-0">
                            <div class="card-body p-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                                    <input type="text" class="form-control border-start-0"
                                        placeholder="Cari berdasarkan No. Nota atau klik di sini..." data-bs-toggle="modal"
                                        data-bs-target="#searchNotaModal" readonly style="cursor: pointer;">
                                    <input type="hidden" id="searchInputNota">
                                    <button class="btn btn-primary d-none" type="button" id="btnSearchNota">Cari Nota</button>
                                </div>
                                <small class="text-muted mt-2 d-block">Masukkan nomor nota lengkap (misal: NOTA-123456) dan klik tombol Cari.</small>
                            </div>
                        </div>

                        <!-- Return Table -->
                        <div class="card shadow-sm border-0 mb-4 mb-lg-0">
                            <div class="card-header bg-white border-bottom">
                                <h5 class="card-title mb-0">Daftar Produk</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive" style="min-height: 400px;">
                                    <table class="table table-hover mb-0 align-middle">
                                        <thead class="table-light text-muted small text-uppercase">
                                            <tr>
                                                <th class="ps-3 border-0 py-3">Produk</th>
                                                <th class="text-center border-0 py-3">Jml Pembelian</th>
                                                <th class="text-center border-0 py-3" style="width: 180px;">Jml Pengembalian</th>
                                                <th class="text-end pe-3 border-0 py-3">Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody id="returnTableBody">
                                            <tr>
                                                <td colspan="4" class="text-center py-5 text-muted" id="tableMessage">
                                                    Silakan cari nota terlebih dahulu.
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right side: Summary & Submit -->
                    <div class="col-lg-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-4 p-3 border rounded border-warning bg-warning bg-opacity-10">
                                    <div>
                                        <small class="text-warning fw-bold d-block text-uppercase mb-1">NO. NOTA</small>
                                        <span class="text-dark fw-bold" id="labelNoNota">-</span>
                                    </div>
                                </div>

                                <div class="alert alert-info border-0 bg-info bg-opacity-10">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Pastikan jumlah pengembalian barang sudah sesuai. Stok barang akan otomatis ditambahkan ke sistem.
                                </div>
                                
                                <div class="mt-auto">
                                    <!-- Process Button -->
                                    <button class="btn btn-warning text-white w-100 py-3 mt-4 fs-5 fw-bold d-flex justify-content-center align-items-center gap-2 text-uppercase rounded"
                                        type="button" id="btnProcessReturn" disabled>
                                        <i class="bi bi-arrow-return-left"></i> Proses Pengembalian
                                    </button>
                                </div>
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

    <!-- Search Nota Modal -->
    <div class="modal fade" id="searchNotaModal" tabindex="-1" aria-labelledby="searchNotaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white border-0">
                    <h5 class="modal-title" id="searchNotaModalLabel"><i class="bi bi-search me-2"></i>Cari Nota Penjualan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="p-3 bg-light border-bottom">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" id="searchInputModalNota"
                                class="form-control form-control-lg border-start-0 ps-0"
                                placeholder="Ketik No. Nota atau nama kasir..." autocomplete="off">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle" id="notaTableModal">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th class="ps-4 text-uppercase small text-muted">No. Nota</th>
                                    <th class="text-uppercase small text-muted">Kasir</th>
                                    <th class="text-uppercase small text-muted">Tanggal</th>
                                    <th class="text-end text-uppercase small text-muted">Total Belanja</th>
                                    <th class="text-end pe-4 text-uppercase small text-muted">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="notaTableBodyModal">
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnSearchNota = document.getElementById('btnSearchNota');
            const searchInputNota = document.getElementById('searchInputNota');
            const returnTableBody = document.getElementById('returnTableBody');
            const labelNoNota = document.getElementById('labelNoNota');
            const btnProcessReturn = document.getElementById('btnProcessReturn');
            
            let currentItems = [];
            let currentNoNota = '';

            function formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID').format(angka);
            }

            btnSearchNota.addEventListener('click', function() {
                const noNota = searchInputNota.value.trim();
                if (!noNota) {
                    Swal.fire('Perhatian', 'Silakan masukkan nomor nota terlebih dahulu', 'warning');
                    return;
                }

                // Tampilkan loading
                returnTableBody.innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </td>
                    </tr>
                `;

                fetch(`{{ url('pengembalian/search') }}/${noNota}`)
                    .then(res => res.json())
                    .then(res => {
                        if (res.status) {
                            currentItems = res.data;
                            currentNoNota = noNota;
                            labelNoNota.textContent = noNota;
                            btnProcessReturn.disabled = false;
                            renderTable();
                        } else {
                            resetState(res.message);
                        }
                    })
                    .catch(err => {
                        console.error("Error fetching nota:", err);
                        resetState("Terjadi kesalahan sistem saat mencari nota.");
                    });
            });

            // Enter key to search
            searchInputNota.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    btnSearchNota.click();
                }
            });

            function resetState(message = 'Silakan cari nota terlebih dahulu.') {
                currentItems = [];
                currentNoNota = '';
                labelNoNota.textContent = '-';
                btnProcessReturn.disabled = true;
                returnTableBody.innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">${message}</td>
                    </tr>
                `;
            }

            function renderTable() {
                returnTableBody.innerHTML = '';

                if (currentItems.length === 0) {
                    resetState('Nota ditemukan tetapi tidak ada produk.');
                    return;
                }

                currentItems.forEach((item, index) => {
                    const tr = document.createElement('tr');
                    
                    tr.innerHTML = `
                        <td class="ps-3 fw-medium">
                            ${item.produk_name}
                            <small class="d-block text-muted">${item.produk_code}</small>
                        </td>
                        <td class="text-center text-muted">${item.max_quantity}</td>
                        <td>
                            <div class="input-group input-group-sm justify-content-center">
                                <button class="btn btn-outline-secondary" type="button" onclick="updateReturnQty(${index}, -1)">-</button>
                                <input type="text" class="form-control text-center bg-white border-secondary" value="${item.return_quantity}" readonly style="max-width: 50px;">
                                <button class="btn btn-outline-secondary" type="button" onclick="updateReturnQty(${index}, 1)">+</button>
                            </div>
                        </td>
                        <td class="text-end pe-3 text-muted">Rp${formatRupiah(item.price_sell)}</td>
                    `;
                    returnTableBody.appendChild(tr);
                });
            }

            window.updateReturnQty = function(index, change) {
                const item = currentItems[index];
                let newQty = item.return_quantity + change;
                
                if (newQty < 0) newQty = 0;
                if (newQty > item.max_quantity) {
                    Swal.fire('Perhatian', 'Jumlah retur tidak boleh melebihi jumlah pembelian pada nota!', 'warning');
                    newQty = item.max_quantity;
                }

                item.return_quantity = newQty;
                renderTable(); // Re-render untuk update UI
            };

            btnProcessReturn.addEventListener('click', function() {
                // Filter barang yang diretur > 0
                const itemsToReturn = currentItems.filter(i => i.return_quantity > 0);
                
                if (itemsToReturn.length === 0) {
                    Swal.fire('Perhatian', 'Tidak ada barang yang dipilih untuk diretur. Sesuaikan jumlah pengembalian minimal 1.', 'warning');
                    return;
                }

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin memproses pengembalian barang ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Proses',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        processReturn(itemsToReturn);
                    }
                });
            });

            function processReturn(itemsToReturn) {
                // Loading state
                btnProcessReturn.disabled = true;
                btnProcessReturn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';

                fetch('{{ route('pengembalian.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        no_nota: currentNoNota,
                        items: itemsToReturn.map(i => ({
                            produk_id: i.produk_id,
                            return_quantity: i.return_quantity
                        }))
                    })
                })
                .then(res => res.json())
                .then(res => {
                    if (res.status) {
                        Swal.fire('Berhasil!', res.message, 'success').then(() => {
                            // Reset semuanya
                            searchInputNota.value = '';
                            resetState();
                        });
                    } else {
                        Swal.fire('Gagal!', res.message, 'error');
                        // Restore button state
                        btnProcessReturn.disabled = false;
                        btnProcessReturn.innerHTML = '<i class="bi bi-arrow-return-left"></i> Proses Pengembalian';
                    }
                })
                .catch(err => {
                    console.error("Error processing return:", err);
                    Swal.fire('Error', 'Terjadi kesalahan sistem saat memproses data.', 'error');
                    // Restore button state
                    btnProcessReturn.disabled = false;
                    btnProcessReturn.innerHTML = '<i class="bi bi-arrow-return-left"></i> Proses Pengembalian';
                });
            }

            // Modal Logic
            const searchNotaModal = document.getElementById('searchNotaModal');
            const searchInputModalNota = document.getElementById('searchInputModalNota');
            const notaTableModal = document.getElementById('notaTableModal');
            let allPenjualans = [];

            if (searchNotaModal && searchInputModalNota && notaTableModal) {
                // Focus input when modal opens
                searchNotaModal.addEventListener('shown.bs.modal', function() {
                    searchInputModalNota.focus();
                    if (allPenjualans.length === 0) {
                        fetchPenjualanList();
                    }
                });

                // Filter table rows based on input
                searchInputModalNota.addEventListener('input', function() {
                    filterNota(this.value.toLowerCase().trim());
                });
            }

            function fetchPenjualanList() {
                const tbody = document.getElementById('notaTableBodyModal');
                tbody.innerHTML = '<tr><td colspan="5" class="text-center py-5 text-muted"><div class="spinner-border spinner-border-sm text-primary" role="status"></div></td></tr>';
                
                fetch('{{ route('pengembalian.listPenjualan') }}')
                    .then(res => res.json())
                    .then(res => {
                        if (res.status) {
                            allPenjualans = res.data;
                            renderPenjualanList(allPenjualans);
                        }
                    })
                    .catch(err => {
                        console.error("Error fetching penjualan list:", err);
                        tbody.innerHTML = '<tr><td colspan="5" class="text-center py-5 text-danger">Gagal memuat daftar nota.</td></tr>';
                    });
            }

            function renderPenjualanList(data) {
                const tbody = document.getElementById('notaTableBodyModal');
                tbody.innerHTML = '';

                if (!data || data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center py-5 text-muted">Tidak ada data penjualan.</td></tr>';
                    return;
                }

                data.forEach(item => {
                    const tr = document.createElement('tr');
                    tr.className = 'nota-row';

                    const noNota = item.nota_id;
                    const kasir = item.user ? item.user.name : '-';
                    // Format date yyyy-mm-dd hh:mm
                    const dateObj = new Date(item.created_at);
                    const tanggal = dateObj.toLocaleString('id-ID', { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit' });
                    const totalFormatted = formatRupiah(item.grand_total || 0);

                    tr.innerHTML = `
                        <td class="ps-4 fw-medium nota-id">${noNota}</td>
                        <td class="nota-kasir text-muted">${kasir}</td>
                        <td>${tanggal}</td>
                        <td class="text-end fw-semibold text-primary">Rp${totalFormatted}</td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-primary rounded-pill px-3" onclick="selectNotaModal('${noNota}')">
                                Pilih
                            </button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });

                if (searchInputModalNota.value) {
                    filterNota(searchInputModalNota.value.toLowerCase().trim());
                }
            }

            function filterNota(query) {
                const rows = notaTableModal.querySelectorAll('.nota-row');
                rows.forEach(row => {
                    const idElement = row.querySelector('.nota-id');
                    const kasirElement = row.querySelector('.nota-kasir');

                    const id = idElement ? idElement.textContent.toLowerCase() : '';
                    const kasir = kasirElement ? kasirElement.textContent.toLowerCase() : '';

                    if (id.includes(query) || kasir.includes(query)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            window.selectNotaModal = function(noNota) {
                // Close modal
                const modal = bootstrap.Modal.getInstance(searchNotaModal);
                if (modal) modal.hide();
                
                // Set input value and click search button
                searchInputNota.value = noNota;
                btnSearchNota.click();
            };
        });
    </script>
@endsection
