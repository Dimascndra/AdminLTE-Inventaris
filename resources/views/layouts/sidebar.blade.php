<!-- Main Sidebar Container -->
<aside class="main-sidebar bg-blue elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('almahira.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-bold">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2 text-capitalize">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-header">{{ __('menu') }}</li>

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link text-white">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>{{ __('dashboard') }}</p>
                    </a>
                </li>

                <!-- Master of Goods -->
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link text-white">
                        <i class="nav-icon fas fa-box"></i>
                        <p>
                            {{ __('Data Master') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('barang.jenis') }}" class="nav-link text-white">
                                <i class="fas fa-angle-right"></i>
                                <p>{{ __('Kategori') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('barang.satuan') }}" class="nav-link text-white">
                                <i class="fas fa-angle-right"></i>
                                <p>{{ __('Lokasi') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('barang.merk') }}" class="nav-link text-white">
                                <i class="fas fa-angle-right"></i>
                                <p>{{ __('Merek') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('barang') }}" class="nav-link text-white">
                                <i class="fas fa-angle-right"></i>
                                <p>{{ __('Barang') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Report -->
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link text-white">
                        <i class="nav-icon fas fa-print"></i>
                        <p>
                            {{ __('Laporan') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('laporan.stok') }}" class="nav-link text-white">
                                <i class="fas fa-angle-right"></i>
                                <p>{{ __('Laporan Barang') }}</p>
                            </a>
                        </li>
                        <!--<li class="nav-item">
              <a href="{{ route('laporan.barangbaru') }}" class="nav-link text-white">
                <i class="fas fa-angle-right"></i>
                <p>{{ __('new goods report') }}</p>
              </a>
            </li> -->
                    </ul>
                </li>

                <!-- Settings -->
                <li class="nav-header">{{ __('others') }}</li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link text-white">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            {{ __('Pengaturan') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (Auth::user()->role->name != 'employee' && Auth::user()->role->name != 'pimpinan')
                            <li class="nav-item">
                                <a href="{{ route('settings.employee') }}" class="nav-link text-white">
                                    <i class="fas fa-angle-right"></i>
                                    <p>{{ __('Petugas') }}</p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('settings.profile') }}" class="nav-link text-white">
                                <i class="fas fa-angle-right"></i>
                                <p>{{ __('profile') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Logout -->
                <li class="nav-item">
                    <a href="{{ route('login.delete') }}" class="nav-link text-white">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>{{ __('messages.logout') }}</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
