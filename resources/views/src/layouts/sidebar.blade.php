 <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
     <!--begin::Sidebar Brand-->
     <div class="sidebar-brand">
         <!--begin::Brand Link-->
         <a href="./index.html" class="brand-link">
             <!--begin::Brand Image-->
             {{-- <img src="{{ asset('dist/assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                 class="brand-image opacity-75 shadow" /> --}}
             <h1 class="brand-image opacity-75 shadow text-white"><i class="bi bi-shop"></i></h1>


             <!--end::Brand Image-->
             <!--begin::Brand Text-->
             <span class="brand-text fw-light">TOKO SALAM</span>
             <!--end::Brand Text-->
         </a>
         <!--end::Brand Link-->
     </div>
     <!--end::Sidebar Brand-->
     <!--begin::Sidebar Wrapper-->
     <div class="sidebar-wrapper">
         <nav class="mt-2">
             <!--begin::Sidebar Menu-->
             <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation"
                 aria-label="Main navigation" data-accordion="false" id="navigation">
                 <li class="nav-item">
                     <a href="{{ route('dashboard') }}"
                         class="nav-link {{ Request::is(['dashboard']) ? 'active' : '' }}">
                         <i class="nav-icon bi bi-columns-gap"></i>
                         <p>Dashboard</p>
                     </a>
                 </li>
                   @role('admin')
                     <li class="nav-item {{ Request::is(['laporan/*']) ? 'menu-open' : '' }}">
                         <a href="#" class="nav-link">
                             <i class="nav-icon bi bi-journal"></i>
                             <p>
                                 Laporan
                                 <i class="nav-arrow bi bi-chevron-right"></i>
                             </p>
                         </a>
                         <ul class="nav nav-treeview">
                             <li class="nav-item">
                                 <a href="{{ route('penjualan.report') }}"
                                     class="nav-link {{ Request::is('laporan/penjualan*') ? 'active': '' }}">
                                     <i class="nav-icon bi bi-graph-up"></i>
                                     <p>Penjualan</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('stok-flow.report', ['type' => 'masuk']) }}"
                                     class="nav-link {{ Request::is('laporan/stock-flow') && request('type') === 'masuk' ? 'active' : '' }}">
                                     <i class="nav-icon bi bi-box-arrow-in-down-left"></i>
                                     <p>Stok Produk Masuk</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('stok-flow.report', ['type' => 'keluar']) }}"
                                     class="nav-link {{ Request::is('laporan/stock-flow') && request('type') === 'keluar' ? 'active' : '' }}">
                                     <i class="nav-icon bi bi-box-arrow-up-right"></i>
                                     <p>Stok Produk Keluar</p>
                                 </a>
                             </li>
                         </ul>
                     </li>
                 @endrole
                  <li class="nav-item">
                     <a href="{{ route('kasir') }}" class="nav-link {{ Request::is(['kasir']) ? 'active' : '' }}">
                         <i class="nav-icon bi bi-pc-display"></i>
                         <p>Kasir</p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('pengembalian.index') }}" class="nav-link {{ Request::is(['pengembalian*']) ? 'active' : '' }}">
                         <i class="nav-icon bi bi-arrow-return-left"></i>
                         <p>Pengembalian Barang</p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('produk') }}"
                         class="nav-link {{ Request::is(['produk', 'produk/*']) ? 'active' : '' }}">
                         <i class="nav-icon bi bi-box-seam"></i>
                         <p>Produk</p>
                     </a>
                 </li>
                 @role('admin')
                    <li class="nav-item">
                        <a href="{{ route('kategori') }}"
                            class="nav-link {{ Request::is(['kategori', 'kategori/*']) ? 'active' : '' }}">
                            <i class="nav-icon bi bi-hash"></i>
                            <p>Kategori</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('userManagement') }}"
                            class="nav-link {{ Request::is(['user-management', 'user-management/*']) ? 'active' : '' }}">
                            <i class="nav-icon bi bi-people"></i>
                            <p>User Management</p>
                        </a>
                    </li>
                 <li class="nav-item">
                        <a href="{{ route('konfigurasi.index') }}"
                            class="nav-link {{ Request::is('konfigurasi*') ? 'active': '' }}">
                            <i class="nav-icon bi bi-gear"></i>
                            <p>Konfigurasi</p>
                        </a>
                    </li>
                 @endrole
                 {{-- <li class="nav-header">PAGES</li> --}}
             </ul>
             <!--end::Sidebar Menu-->
         </nav>
     </div>
     <!--end::Sidebar Wrapper-->
 </aside>
