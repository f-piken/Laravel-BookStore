@extends('layouts.landing') <!-- Gunakan layout yang sesuai, seperti 'app.blade.php' -->

@section('title', 'Profil')
@section('page', 'User')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm rounded-lg">
                <div class="card-header text-center text-white" style="background-color: #B4D51E;">
                    <h5>Informasi Profil</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('customers.update', $customers->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Gunakan PUT karena ini adalah update -->

                        <div class="row mb-3">
                            <div class="col-md-4">
                                @if($user->photo)
                                    <!-- Foto Profil -->
                                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil" class="rounded-circle img-fluid" width="150" style="border: #B4D51E 2px solid;">
                                @else
                                    <img src="https://via.placeholder.com/150" alt="Foto Profil" class="rounded-circle img-fluid" width="150">
                                @endif
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $user->name) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="email" value="{{ old('email', $user->email) }}" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control" id="phone" value="{{ old('phone', $customers->phone) }}" placeholder="Silahkan isi nomor telepon anda" required>
                                </div>
                                <div class="mb-3">
                                    <label for="province" class="form-label">Provinsi</label>
                                    <input type="text" name="province" class="form-control" id="province" value="{{ old('province', $customers->province) }}" placeholder="Silahkan isi provinsi anda">
                                </div>
                                <div class="mb-3">
                                    <label for="city" class="form-label">Kota</label>
                                    <input type="text" name="city" class="form-control" id="city" value="{{ old('city', $customers->city) }}" placeholder="Silahkan isi kota anda">
                                </div>
                                <div class="mb-3">
                                    <label for="postal_code" class="form-label">Kode Pos</label>
                                    <input type="text" name="postal_code" class="form-control" id="postal_code" value="{{ old('postal_code', $customers->postal_code) }}" placeholder="Silahkan isi kode pos anda">
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Alamat</label>
                                    <textarea name="address" class="form-control" id="address" rows="2" placeholder="Silahkan isi alamat lengkap anda">{{ old('address', $customers->address) }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="photo" class="form-label">Foto Profil</label>
                                    <input type="file" name="photo" class="form-control" id="photo">
                                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success px-4 py-2 rounded-pill shadow-sm">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
