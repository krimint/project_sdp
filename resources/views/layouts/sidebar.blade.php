<!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
            </li>
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
            </li>
        </ul>
    </nav>
<!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="/assets/index3.html" class="brand-link">
            <img src="/assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Resto</span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                <img src="/assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                </div>
            </div>
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column">
                    <li class="nav-item">
                        <a href="/dashboard" class="nav-link">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    @if(Auth::user()->role == 'Admin')
                    <li class="nav-item">
                        <a href="/report" class="nav-link">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>Report</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('menu.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>Menu</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('paket.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>Paket</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('meja.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>Meja</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('posts.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>Pengguna</p>
                        </a>
                    </li>
                    <li class="nav-item mt-5">
                        <a href="/logout" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a href="/trx" class="nav-link">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>Transaksi</p>
                        </a>
                    </li>

                    <li class="nav-item mt-5">
                        <a href="/logout" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                    @endif
                </ul>
            </nav>
        </div>
    </aside>
