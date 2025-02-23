@extends('layouts.app')

@section('title')
    Editors - Admin
@endsection

@section('content')
<div class="card mt-4 table-container" style="width: 980px; transition: margin-left 0.3s ease-in-out, width 0.3s ease-in-out;">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 style="color: white;">Daftar Editor</h5>
        <!-- Button trigger modal -->
    </div>
    <div class="card-body">
        <div class="table-responsive tabel" style="max-width: 980px; overflow-x: auto;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Nomor Telepon</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($editors as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->phone ?? '-' }}</td>
                            <td>{{ $item->address ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin-editors.edit', $item->user->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('admin-editors.delete', $item->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit" 
                                            onclick="return confirm('Yakin ingin menghapus penjual ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data penjual.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-flex justify-content-end">
            {{ $editors->links() }}
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
            document.getElementById('editDescription').value = product.deskripsi;
            document.getElementById('editTahunTerbit').value = product.tahun_terbit;

            // Atur action form sesuai dengan URL update
            document.getElementById('editProductForm').action = `/toko/${product.id}`;

            // Tampilkan modal
            new bootstrap.Modal(document.getElementById('editProductModal')).show();
        });
    });
</script>
@endpush