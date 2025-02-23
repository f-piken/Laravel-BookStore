@extends('layouts.app')

@section('title')
    Akun - Admin
@endsection

@section('content')
<div class="card mt-4 table-container" style="width: 980px; transition: margin-left 0.3s ease-in-out, width 0.3s ease-in-out;">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mt-3" style="color: white;">Daftar Pengguna</h5>
        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#createUserModal">
            Tambah Buku
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive tabel" style="max-width: 980px; overflow-x: auto;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td>
                                @if($user->photo)
                                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto" style="width: 50px; height: 50px; border-radius: 50%;">
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm btn-edit" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editUserModal"
                                        data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}"
                                        data-email="{{ $user->email }}"
                                        data-role="{{ $user->role }}">
                                    Edit
                                </button>
                                <form action="{{ route('admin-users.destroy', $user->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit" 
                                            onclick="return confirm('Yakin ingin menghapus pengguna ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-flex justify-content-end">
            {{ $users->links() }}
        </div>
    </div>
</div>
@include('users.create')
@include('users.edit')
@endsection

@push('scripts')
    <!-- Script untuk mengisi data modal -->
    <script>
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function () {
                const userId = this.getAttribute('data-id');
                const userName = this.getAttribute('data-name');
                const userEmail = this.getAttribute('data-email');
                const userRole = this.getAttribute('data-role');
    
                document.getElementById('editUserId').value = userId;
                document.getElementById('editName').value = userName;
                document.getElementById('editEmail').value = userEmail;
                document.getElementById('editRole').value = userRole;
    
                document.getElementById('editUserForm').action = `/admin-users/${userId}`;
            });
        });
    </script>
@endpush
