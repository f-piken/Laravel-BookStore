@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
<div class="card mt-4 table-container">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mt-3" style="color: white;">Daftar Buku</h5>
        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#createBukuModal">
            Tambah Buku
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Penulis</th>
                        <th>Tahun Terbit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->judul }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->penulis }}</td>
                            <td>{{ $product->tahun_terbit }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editBookModal-{{ $product->id }}">
                                    Edit
                                </button>
                                <a href="{{ route('admin-books.show', $product->id) }}" class="btn btn-primary btn-sm">View</a>
                                <form action="{{ route('admin-books.destroy', $product->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @include('book.edit')
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-flex justify-content-end">
            {{ $books->links() }}
        </div>
    </div>
</div>
@include('book.create')
@endsection
