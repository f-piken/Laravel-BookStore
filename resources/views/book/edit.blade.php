<!-- Edit Modal -->
<div class="modal fade" id="editBookModal-{{ $product->id }}" tabindex="-1" aria-labelledby="editBookLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin-books.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editBookLabel">Edit Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editJudul-{{ $product->id }}" class="form-label">Judul Buku</label>
                        <input type="text" class="form-control" id="editJudul-{{ $product->id }}" name="judul" value="{{ $product->judul }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="editTahunTerbit-{{ $product->id }}" class="form-label">Tahun Terbit</label>
                        <input type="number" class="form-control" id="editTahunTerbit-{{ $product->id }}" name="tahun_terbit" value="{{ $product->tahun_terbit }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEditor-{{ $product->id }}" class="form-label">Penulis</label>
                        <select class="form-select" id="editEditor-{{ $product->id }}" name="editor_id" required>
                            <option value="" disabled>Penulis</option>
                            @foreach ($editors as $editor)
                                <option value="{{ $editor->id }}" {{ $product->editor_id == $editor->id ? 'selected' : '' }}>{{ $editor->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editCategory-{{ $product->id }}" class="form-label">Kategori</label>
                        <select class="form-select" id="editCategory-{{ $product->id }}" name="category_id" required>
                            <option value="" disabled>Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editDeskripsi-{{ $product->id }}" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="editDeskripsi-{{ $product->id }}" name="deskripsi" rows="3">{{ $product->deskripsi }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editImage-{{ $product->id }}" class="form-label">Gambar Buku</label>
                        <input type="file" class="form-control" id="editImage-{{ $product->id }}" name="image" accept="image/*">
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