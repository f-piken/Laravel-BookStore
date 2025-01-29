<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('tamplate/css/login.css') }}">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="row w-100">
            <div class="col-lg-6 mx-auto">
                <div class="card shadow-lg">
                    <div class="card-header text-center">
                        <h3>Register</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/register') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Kolom 1: Form Input -->
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select name="role" class="form-select" required>
                                        <option value="seller">Seller</option>
                                        <option value="customer">Customer</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="photo" class="form-label">Profile Photo</label>
                                    <input type="file" name="photo" class="form-control" accept="image/*">
                                    @error('photo')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <p>Sudah memiliki akun? <a href="{{ route('login') }}">login</a></p>
                            <button type="submit" class="btn btn-primary w-100">Register</button>
                        </form>
                    </div>
                </div>
                {{-- <div class="col-lg-6 d-none d-lg-block">
                    <div class="card h-100">
                        <img src="https://via.placeholder.com/300x300" class="card-img-top" alt="Register Image">
                        <div class="card-body">
                            <h5 class="card-title">Join Us Today!</h5>
                            <p class="card-text">Create an account to enjoy all the benefits we offer. Sign up now and be part of our growing community.</p>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="{{ asset('template/js/login.js') }}"></script>
</body>
</html>
