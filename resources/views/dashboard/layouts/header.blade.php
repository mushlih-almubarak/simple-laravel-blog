<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="/">MSH Web</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
        data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <form class="w-100"
        action="{{ (Request::is('dashboard/kategori/*')) ? '/dashboard/kategori/' . last(request()->segments()) : '/dashboard/artikel' }}">
        <input class="form-control form-control-dark" type="text" name="cari" placeholder="Cari artikel..."
            value="{{ request('cari') }}">
    </form>
    <div class="navbar-nav">
        <div class="nav-item text-nowrap">
            <form action="/logout" method="post">
                @csrf
                <button type="submit" class="nav-link px-3 bg-dark border-0">
                    Logout
                    <span data-feather="log-out"></span>
                </button>
            </form>
        </div>
    </div>
</header>