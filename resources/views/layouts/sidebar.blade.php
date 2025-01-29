<div class="sidebar" id="sidebar">
    <div class="button">
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <h4 class="judul text-center">Admin Panel</h4>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin-dashboard') }}">
                <i class='bx bxs-dashboard icon-large'></i><span class="nama">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('categories.index') }}">
                <i class='bx bx-category-alt icon-large'></i><span class="nama">Categories</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('products.index') }}">
                <i class='bx bx-basket icon-large'></i><span class="nama">Products</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('orders.index') }}">
                <i class='bx bx-transfer-alt icon-large' ></i><span class="nama">Orders</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('customers.data') }}">
                <i class='bx bx-user icon-large'></i><span class="nama">Customers</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('sellers.data') }}">
                <i class='bx bx-store-alt icon-large'></i><span class="nama">Sellers</span>
            </a>
        </li>
        <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="nav-link" style="background: none; border: none;">
                    <i class='bx bx-log-out-circle icon-large' ></i><span class="nama">Logout</span>
                </button>
            </form>
        </li>
    </ul>
</div>