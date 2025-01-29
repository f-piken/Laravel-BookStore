@extends('layouts.app')

@section('title')
    Sellers - Admin
@endsection

@section('content')
<div class="card mt-4 table-container" style="width: 980px; transition: margin-left 0.3s ease-in-out, width 0.3s ease-in-out;">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 style="color: white;">Daftar Penjual</h5>
        <!-- Button trigger modal -->
        {{-- <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#createSellerModal">
            Tambah Penjual
        </button> --}}
    </div>
    <div class="card-body">
        <div class="table-responsive tabel" style="max-width: 980px; overflow-x: auto;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama User</th>
                        <th>Nama Toko</th>
                        <th>Nomor Telepon</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sellers as $seller)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $seller->user->name }}</td>
                            <td>{{ $seller->store_name }}</td>
                            <td>{{ $seller->phone ?? '-' }}</td>
                            <td>{{ $seller->address ?? '-' }}</td>
                            <td>
                                <!-- Edit Button -->
                                {{-- <button class="btn btn-primary btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editSellerModal-{{ $seller->id }}">
                                    Edit
                                </button> --}}
                                <!-- Delete Button -->
                                <form action="{{ route('sellers.delete', $seller->id) }}" method="POST" style="display: inline-block;">
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
            {{ $sellers->links() }}
        </div>
    </div>
</div>

@endsection
