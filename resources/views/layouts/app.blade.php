<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Tambahkan CSS framework seperti Bootstrap dan Font Awesome -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
    <link rel="stylesheet" href="{{ asset('tamplate/css/admin.css') }}">
</head>
<body>
    @include('layouts.sidebar')
    
    @include('layouts.topbars')
    <div class="container-fluid" style="margin-left: 250px; transition: margin-left 0.3s ease-in-out; width: 80%;" id="main-content">
        <div class="row">
            <!-- Main Content -->
            <main class="col-md-12 p-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Tambahkan JavaScript framework seperti Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
    <script src="{{ asset('tamplate/js/admin.js') }}"></script>
</body>
</html>
