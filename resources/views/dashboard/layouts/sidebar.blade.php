<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" aria-current="page"
                    href="/dashboard">
                    <span data-feather="home"></span>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard/artikel') ? 'active' : '' }}" href="/dashboard/artikel">
                    <span data-feather="file-text"></span>
                    Artikel Saya
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard/artikel/buat-baru') ? 'active' : '' }}"
                    href="/dashboard/artikel/buat-baru">
                    <span data-feather="file-plus"></span>
                    Buat Artikel
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/penulis">
                    <x-bi-people />
                    Semua User
                </a>
            </li>
            @can('all-actions')
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>Administrator</span>
            </h6>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ (Request::is('dashboard/kategori') ? 'active' : '') }}"
                        href="/dashboard/kategori">
                        <span data-feather="grid"></span>
                        Semua Kategori
                    </a>
                </li>
            </ul>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard/kategori/buat-baru') ? 'active' : '' }}"
                    href="/dashboard/artikel/buat-baru">
                    <span data-feather="file-plus"></span>
                    Buat Kategori
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard/users') ? 'active' : '' }}" href="/dashboard/users">
                    <span data-feather="users"></span>
                    Semua Pengguna
                </a>
            </li>
            @endcan
        </ul>
    </div>
</nav>