@extends('layouts.app')

@section('title')
    Categories - Admin
@endsection

@section('content')
<div class="card mt-4 table-container" style="width: 980px; transition: margin-left 0.3s ease-in-out, width 0.3s ease-in-out;">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mt-3" style="color: white;">Daftar Kategori</h5>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
            Tambah Kategori
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive tabel" style="max-width: 980px; overflow-x: auto;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description ?? '-' }}</td>
                            <td>
                                <!-- Edit Button -->
                                <button class="btn btn-primary btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editCategoryModal-{{ $category->id }}">
                                    Edit
                                </button>
                                <!-- Delete Button -->
                                <form action="{{ route('admin-categories.destroy', $category->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit" 
                                            onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>

                        @include('category.edit')
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-flex justify-content-end">
            {{ $categories->links() }}
        </div>
    </div>
</div>

@include('category.create')
@endsection
