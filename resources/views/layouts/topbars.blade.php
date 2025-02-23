<div class="topbar bg-light d-flex justify-content-between align-items-center px-4 py-2" id="atas" style="margin-left: 250px; transition: margin-left 0.3s ease-in-out; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
    <!-- Judul Halaman -->
    <div class="page-title">
        <h5 class="mb-0">@yield('title', 'Dashboard')</h5>
    </div>

    <!-- Navigasi Kanan -->
    <div class="d-flex align-items-center">
        <!-- Pencarian -->
        @php
            $action = match($currentPage ?? '') {
                'admin-categories' => route('admin-categories.index'),
                'admin-books' => route('admin-books.index'),
                'admin-users' => route('admin-users.index'),
                'admin-editors' => route('admin-editors.data'),
                'admin-viewers' => route('admin-viewers.data'),
                default => '#',
            };
        @endphp
        
        <form class="d-flex me-3" action="{{ $action }}" method="GET" style="width: 300px;">
            <input class="form-control form-control-sm" type="text" name="q" value="{{ request('q') }}" placeholder="Cari..." aria-label="Search">
            <button class="btn btn-sm btn-primary ms-2" type="submit">
                <i class='bx bx-search-alt-2'></i>
            </button>
        </form>

        <!-- Menu Pengguna -->
        <div class="dropdown">
            <button class="btn btn-sm btn-light dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('images/default_profile.jpg') }}" alt="" class="icon"> {{ Auth::user()->name ?? 'Guest' }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                {{-- <li><a class="dropdown-item" href="/profile">Profil</a></li>
                <li><a class="dropdown-item" href="/settings">Pengaturan</a></li> --}}
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="dropdown-item">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
