<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('tamplate/css/login.css') }}">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="{{ url('/register') }}" method="POST" enctype="multipart/form-data">
                @csrf
    			<h1>Create Account</h1>
    			<span>or use your email for registration</span>
    			<input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Name" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Email" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <input type="password" name="password" class="form-control" placeholder="New Password" required>
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                @error('password_confirmation')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <select name="role" class="form-select" required>
                    <option value="">Anda Penjual Atau Pembeli?</option>
                    <option value="customer">Customer</option>
                    <option value="seller">Seller</option>
                </select>
                @error('role')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                
    			<button type="submit">Sign Up</button>
    		</form>
    	</div>
    	<div class="form-container sign-in-container">
            <a href="{{ url('/') }}">
                <i class="bx bx-left-arrow-alt bx-md" style="color: black;"></i>
            </a>
    		<form action="{{ url('/login') }}" method="POST">
                @csrf
    			<h1>Sign in</h1>
    			<span>or use your account</span>
    			<input type="email" name="email" placeholder="Email" />
    			<input type="password" name="password" placeholder="Password" />
    			{{-- <a href="#">Forgot your password?</a> --}}
    			<button type="submit">Sign In</button>
    		</form>
    	</div>
    	<div class="overlay-container">
            <div class="overlay">
                <a href="{{ url('/') }}">
                    <i class="bx bx-left-arrow-alt bx-md" style="color: white;"></i>
                </a>
                <div class="overlay-panel overlay-left">
    				<h1>Welcome Back!</h1>
    				<p>To keep connected with us please login with your personal info</p>
    				<button class="ghost" id="signIn">Sign In</button>
    			</div>
    			<div class="overlay-panel overlay-right">
    				<h1>Hello, Friend!</h1>
    				<p>Enter your personal details and start journey with us</p>
    				<button class="ghost" id="signUp">Sign Up</button>
    			</div>
    		</div>
    	</div>
    </div>
    <script src="{{ asset('tamplate/js/login.js') }}"></script>
</body>
</html>
