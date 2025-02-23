@extends('layouts.landing') <!-- Gunakan layout yang sesuai, seperti 'app.blade.php' -->

@section('title', 'Toko')
@section('page', 'Toko')

@section('sub')
<li class="breadcrumb-item active" aria-current="page">Editor</li>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="d-flex justify-content-center mb-4">
            <a href="{{ route('editors.index') }}" class="btn btn-outline-secondary me-2">Profil</a>
            <a href="{{ route('editors.books', $editor->id) }}" class="btn btn-outline-primary me-2">Buku</a>
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6">
                    <h1>
                        <img src="{{ asset('storage/' . $editor->store_logo) }}" alt="" class="store">
                         {{ $editor->store_name ?? 'Belum Ada Nama Pena' }}
                        </h1>
                </div>
                <div class="col-6 text-end">
                    <button type="button" class="btn-first" data-bs-toggle="modal" data-bs-target="#createProductModal">
                        Tambah Buku
                    </button>
                </div>                
            </div>
            <div class="row mt-5">
                @foreach ($book as $product)
                <div class="col-lg-3 col-6">
                    <div class="card card-product card-body p-lg-4 p3">
                        <a href="{{ route('book.show', $product->id) }}">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="" class="img-fluid">
                        </a>
                        <h3 class="product-name mt-3">{{ $product->judul }}</h3>
                        <div class="detail d-flex justify-content-between align-items-center mt-4">
                            <div>
                                <p class="penulis">{{ $product->penulis }}</p>
                                <p class="penulis">Tahun {{ $product->tahun_terbit }}</p>
                            </div>
                            <form action="{{ route('editors.book.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
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
            <form action="{{ route('editors.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createBookModalLabel">Tambah Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="createJudul" class="form-label">Judul Buku</label>
                        <input type="text" class="form-control" id="createJudul" name="judul" required>
                    </div>
                    <input type="hidden" class="form-control" id="editor_id" name="editor_id" value="{{ $editor->id }}" required>
                    <div class="mb-3">
                        <label for="createTahunTerbit" class="form-label">Tahun Terbit</label>
                        <input type="number" class="form-control" id="createTahunTerbit" name="tahun_terbit" required>
                    </div>
                    <div class="mb-3">
                        <label for="createCategory" class="form-label">Kategori</label>
                        <select class="form-select" id="createCategory" name="category_id" required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="createDeskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="createDeskripsi" name="deskripsi" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="createImage" class="form-label">Gambar Buku</label>
                        <input type="file" class="form-control" id="createImage" name="image" accept="image/*" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah Buku</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Book -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editProductForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editProductId" name="product_id">
                    <div class="mb-3">
                        <label for="editName" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="editName" name="judul" required>
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
                        <label for="createTahunTerbit" class="form-label">Tahun Terbit</label>
                        <input type="number" class="form-control" id="editTahunTerbit" name="tahun_terbit" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDeskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="editDeskripsi" name="deskripsi" rows="3"></textarea>
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
            document.getElementById('editName').value = product.judul;
            document.getElementById('editCategory').value = product.category_id;
            document.getElementById('editDeskripsi').value = product.deskripsi;
            document.getElementById('editTahunTerbit').value = product.tahun_terbit;

            // Atur action form sesuai dengan URL update
            document.getElementById('editProductForm').action = `/book/edit/${product.id}`;

            // Tampilkan modal
            new bootstrap.Modal(document.getElementById('editProductModal')).show();
        });
    });
</script>
@endpush
