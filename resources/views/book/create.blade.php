<!-- Create Modal -->
<div class="modal fade" id="createBukuModal" tabindex="-1" aria-labelledby="createBukuLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin-books.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createBukuLabel">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="createJudul" class="form-label">Judul Buku</label>
                        <input type="text" class="form-control" id="createJudul" name="judul" required>
                    </div>
                    {{-- <input type="hidden" class="form-control" id="editor_id" name="editor_id" value="{{ $editor->id }}" required> --}}
                    <div class="mb-3">
                        <label for="createTahunTerbit" class="form-label">Tahun Terbit</label>
                        <input type="number" class="form-control" id="createTahunTerbit" name="tahun_terbit" required>
                    </div>
                    <div class="mb-3">
                        <label for="editor_id" class="form-label">Kategori</label>
                        <select class="form-select" id="editor_id" name="editor_id" required>
                            <option value="" disabled selected>Penulis</option>
                            @foreach ($editors as $editor)
                                <option value="{{ $editor->id }}">{{ $editor->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="categoryBuku" class="form-label">Kategori</label>
                        <select class="form-select" id="categoryBuku" name="category_id" required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
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
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>