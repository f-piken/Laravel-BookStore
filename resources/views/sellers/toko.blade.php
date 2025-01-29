@extends('layouts.landing') <!-- Gunakan layout yang sesuai, seperti 'app.blade.php' -->

@section('title', 'Toko')
@section('page', 'Toko')

@section('sub')
<li class="breadcrumb-item active" aria-current="page">Seller</li>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="d-flex justify-content-center mb-4">
            <a href="{{ route('sellers.index') }}" class="btn btn-outline-secondary me-2">Profil</a>
            <a href="{{ route('sellers.toko') }}" class="btn btn-outline-primary me-2">Toko</a>
            <a href="{{ route('sellers.pesanan') }}" class="btn btn-outline-secondary">Pesanan</a>
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6">
                    <h1>
                        <img src="{{ asset('storage/' . $seller->store_logo) }}" alt="" class="store">
                         {{ $seller->store_name ?? 'Belum Ada Nama Toko' }}
                        </h1>
                </div>
                <div class="col-6 text-end">
                    <button type="button" class="btn-first" data-bs-toggle="modal" data-bs-target="#createProductModal">
                        Tambah Produk
                    </button>
                </div>                
            </div>
            <div class="row mt-5">
                @foreach ($product as $product)
                <div class="col-lg-3 col-6">
                    <div class="card card-product card-body p-lg-4 p3">
                        <a href="">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="" class="img-fluid">
                        </a>
                        <h3 class="product-name mt-3">{{ $product->name }}</h3>
                        <div class="rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="bx {{ $i <= $product->rate ? 'bxs-star' : 'bx-star' }}"></i>
                            @endfor
                        </div>
                        <div class="detail d-flex justify-content-between align-items-center mt-4">
                            <p class="price">IDR {{ number_format($product->price, 0, ',', '.') }}</p>
                            <form action="{{ route('sellers.toko.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-cart btn-edit" style="background-color: transparent; border: none;"><i class="bx bx-trash"></i></button>
                            </form>
                            <button type="button" class="btn-cart btn-edit" data-product='@json($product)' style="background-color: transparent; border: none; "><i class='bx bx-edit-alt'></i></button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>            
    </div>
</div>

<!-- Modal Create Product -->
<div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('sellers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" id="seller_id" name="seller_id" value="{{ $seller->id }}" required>
                <div class="modal-header">
                    <h5 class="modal-title" id="createProductModalLabel">Tambah Produk Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama produk" required>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Kategori</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Masukkan deskripsi produk"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="price" name="price" placeholder="Masukkan harga produk" required>
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="stock" name="stock" placeholder="Masukkan jumlah stok" required>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar Produk</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Edit Product -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editProductForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editProductId" name="product_id">
                    <div class="mb-3">
                        <label for="editName" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editCategory" class="form-label">Kategori</label>
                        <select class="form-select" id="editCategory" name="category_id" required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="editDescription" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editPrice" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="editPrice" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="editStock" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="editStock" name="stock" required>
                    </div>
                    <div class="mb-3">
                        <label for="editImage" class="form-label">Gambar Produk</label>
                        <input type="file" class="form-control" id="editImage" name="image" accept="image/*">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function () {
            const product = JSON.parse(this.dataset.product);

            // Isi data ke dalam modal
            document.getElementById('editProductId').value = product.id;
            document.getElementById('editName').value = product.name;
            document.getElementById('editCategory').value = product.category_id;
            document.getElementById('editDescription').value = product.description;
            document.getElementById('editPrice').value = product.price;
            document.getElementById('editStock').value = product.stock;

            // Atur action form sesuai dengan URL update
            document.getElementById('editProductForm').action = `/toko/${product.id}`;

            // Tampilkan modal
            new bootstrap.Modal(document.getElementById('editProductModal')).show();
        });
    });
</script>
@endpush
