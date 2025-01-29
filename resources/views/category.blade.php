@extends('layouts.landing') <!-- Gunakan layout yang sesuai, seperti 'app.blade.php' -->

@section('title', 'Categories')
@section('page', 'Categories')

@section('content')
<section class="">
    <div class="container">
        <div class="d-flex justify-content-start mb-4">
            <!-- Tombol untuk memilih 'All' -->
            <a href="#" class="btn btn-outline-primary me-2 category-btn" onclick="changeCategory(this, 0)">All</a>

            <!-- Loop kategori -->
            @foreach ($categories as $item)
                <a href="#" class="btn btn-outline-secondary me-2 category-btn" data-category-id="{{ $item->id }}" onclick="changeCategory(this, {{ $item->id }})">{{ $item->name }}</a>
            @endforeach
        </div>

        <div class="row align-items-center">
            <div class="col-6">
                <h1 id="category-title">All</h1> {{-- Judul kategori yang berubah --}}
            </div>
        </div>
        
        <div class="row" id="products-container">
            {{-- Produk yang sesuai dengan kategori akan ditampilkan di sini --}}
        </div>
    </div>
</section>
@endsection

@push('script')
<script>
    // Fungsi untuk mengubah kategori
    function changeCategory(element, categoryId) {
        // Mengubah kelas tombol terpilih
        const buttons = document.querySelectorAll('.category-btn');
        buttons.forEach(button => {
            button.classList.remove('btn-outline-primary');
            button.classList.add('btn-outline-secondary');
        });
    
        element.classList.remove('btn-outline-secondary');
        element.classList.add('btn-outline-primary');
        // Mengubah teks judul kategori
        const title = document.getElementById('category-title');
        title.textContent = categoryId === 0 ? 'All' : element.textContent; // Jika All dipilih, teks judul akan menjadi 'All'
        // Menampilkan produk sesuai kategori
        fetchProductsByCategory(categoryId);
    }
    // Fungsi untuk mengambil dan menampilkan produk berdasarkan kategori
    function fetchProductsByCategory(categoryId) {
        let url = categoryId === 0 ? '/api/products/all' : `/api/products/category/${categoryId}`;
        fetch(url)
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('products-container');
                container.innerHTML = '';  // Reset produk yang ditampilkan
            
                if (data.products.length === 0) {
                    // Jika tidak ada produk, tampilkan keterangan
                    const noProductsMessage = document.createElement('p');
                    noProductsMessage.textContent = 'No products found';
                    container.appendChild(noProductsMessage);
                } else {
                    // Jika ada produk, tampilkan produk
                    data.products.forEach(product => {
                        const productElement = document.createElement('div');
                        productElement.classList.add('col-lg-3', 'col-6');
                        productElement.innerHTML = `
                            <div class="card card-product card-body p-lg-4 p3">
                                <a href="/product/${product.id}">
                                    <img src="${window.location.origin}/storage/${product.image}" alt="${product.name}" class="img-fluid">
                                </a>
                                <h3 class="product-name mt-3">${product.name}</h3>
                                <div class="rating">
                                    ${generateStars(product.rate)}
                                </div>
                                <div class="detail d-flex justify-content-between align-items-center mt-4">
                                    <p class="price">IDR ${product.price}</p>
                                    <a href="/product/${product.id}" class="btn-cart"><i class="bx bx-cart-alt"></i></a>
                                </div>
                            </div>
                        `;
                        container.appendChild(productElement);
                    });
                }
            });
    }
    // Panggil `fetchProductsByCategory(0)` saat halaman pertama kali dimuat
    document.addEventListener('DOMContentLoaded', () => {
        fetchProductsByCategory(0);
    });
    // Fungsi untuk menghasilkan bintang berdasarkan rating produk
    function generateStars(rate) {
        let stars = '';
        for (let i = 1; i <= 5; i++) {
            stars += i <= rate ? '<i class="bx bxs-star"></i>' : '<i class="bx bx-star"></i>';
        }
        return stars;
    }
</script>
@endpush

