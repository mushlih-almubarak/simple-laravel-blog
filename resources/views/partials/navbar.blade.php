<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/">MSH Blog</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link  {{ (Request::getRequestUri() === '/') ? 'active' : '' }}" href="/">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ (Request::getRequestUri() === '/tentang-saya') ? 'active' : '' }}"
                        href="/tentang-saya">Tentang
                        Saya</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ (Request::getRequestUri() === '/blog' || request()->segment(2)) ? 'active' : '' }}"
                        href="/blog">Artikel</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ (Request::getRequestUri() === '/kategori' || request()->query('kategori')) ? 'active' : '' }}"
                        href="javascript:void(0)" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Kategori
                    </a>
                    <ul class="dropdown-menu">
                        @foreach(App\Models\Category::all() as $category)
                        <li><a class="dropdown-item" href="/blog?kategori={{ $category->slug }}">{{ $category->name
                                }}</a></li>
                        @endforeach
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="/kategori">Semua Kategori</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ (Request::getRequestUri() === '/penulis' || request()->query('penulis')) ? 'active' : '' }}"
                        href="javascript:void(0)" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Penulis
                    </a>
                    <ul class="dropdown-menu">
                        @foreach(App\Models\User::all() as $author)
                        <li><a class="dropdown-item" href="/blog?penulis={{ $author->username }}">{{ $author->name
                                }}</a></li>
                        @endforeach
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="/penulis">Semua Penulis</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Selamat datang, {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="/dashboard">
                                <x-bi-layout-text-sidebar-reverse />
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="/logout" method="post">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <x-bi-box-arrow-right />
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ (Request::getRequestUri() === '/login' || Request::getRequestUri() === '/daftar' || Request::getRequestUri() === '/lupa-password') ? 'active' : '' }}"
                        href="javascript:void(0)" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <x-bi-box-arrow-in-right />
                        <span class="ms-1">Login</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="/login">
                                <x-bi-box-arrow-in-right />
                                <span class="ms-1">Login</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="/daftar">
                                <x-bi-person-plus />
                                <span class="ms-1">Daftar</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/lupa-password">
                                <x-bi-lock />
                                <span class="ms-1">Lupa Password</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>