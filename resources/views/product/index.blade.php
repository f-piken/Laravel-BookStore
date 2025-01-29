@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
<div class="card mt-4 table-container">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 style="color: white;">Daftar Produk</h5>
        {{-- <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#createProductModal">
            Tambah Produk
        </button> --}}
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>IDR {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                {{-- <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm">Edit</a> --}}
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-flex justify-content-end">
            {{ $products->links() }}
        </div>
    </div>
</div>

@endsection
