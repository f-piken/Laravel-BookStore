@extends('layouts.app')

@section('title')
    Customers - Admin
@endsection

@section('content')
<div class="card mt-4 table-container" style="width: 980px; transition: margin-left 0.3s ease-in-out, width 0.3s ease-in-out;">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 style="color: white;">Daftar Pelanggan</h5>
        <!-- Button trigger modal -->
        {{-- <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#createCustomerModal">
            Tambah Pelanggan
        </button> --}}
    </div>
    <div class="card-body">
        <div class="table-responsive tabel" style="max-width: 980px; overflow-x: auto;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Pelanggan</th>
                        <th>Nomor Telepon</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $customer->user->name ?? '-' }}</td>
                            <td>{{ $customer->phone ?? '-' }}</td>
                            <td>{{ $customer->address ?? '-' }}</td>
                            <td>
                                <!-- Edit Button -->
                                {{-- <button class="btn btn-primary btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editCustomerModal-{{ $customer->id }}">
                                    Edit
                                </button> --}}
                                <!-- Delete Button -->
                                <form action="{{ route('customers.delete', $customer->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit" 
                                            onclick="return confirm('Yakin ingin menghapus pelanggan ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data pelanggan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-flex justify-content-end">
            {{ $customers->links() }}
        </div>
    </div>
</div>

@endsection
