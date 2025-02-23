<div class="sidebar" id="sidebar">
    <div class="button">
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <h4 class="judul text-center">Admin Panel</h4>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin-dashboard.index') }}">
                <i class='bx bxs-dashboard icon-large'></i><span class="nama">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin-categories.index') }}">
                <i class='bx bx-category-alt icon-large'></i><span class="nama">Kategori</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin-books.index') }}">
                <i class='bx bx-basket icon-large'></i><span class="nama">Buku</span>
            </a>
        </li>

        <!-- Dropdown Menu -->
        <li class="nav-item">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-bs-toggle="collapse" data-bs-target="#userMenu">
                <i class='bx bx-user icon-large'></i><span class="nama">Pengguna</span>
            </a>
            <ul class="collapse nav flex-column ms-3" id="userMenu">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin-users.index') }}">
                        <i class='bx bx-user icon-large'></i><span class="nama">Akun</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#createUserModal">
                        <i class='bx bx-plus icon-large'></i><span class="nama">Tambah Pengguna</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin-viewers.data') }}">
                        <i class='bx bx-show-alt icon-large'></i><span class="nama">Viewers</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin-editors.data') }}">
                        <i class='bx bx-edit icon-large'></i><span class="nama">Editors</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="nav-link" style="background: none; border: none;">
                    <i class='bx bx-log-out-circle icon-large'></i><span class="nama">Logout</span>
                </button>
            </form>
        </li>
    </ul>
</div>
@include('users.create')