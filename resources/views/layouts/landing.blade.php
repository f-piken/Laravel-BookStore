<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('tamplate/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('tamplate/css/main.css') }}">
    <title>WijayaBook: Official Site</title>
</head>
<body>
  @include('layouts.navbar')
  <section class="breadcrumb-section pb-4 pb-md-4 pt-4 pt-md-4">
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                @yield('sub')
                <li class="breadcrumb-item active" aria-current="page">@yield('page')</li>
            </ol>
        </nav>
    </div>
  </section>

    @yield('content')

  @include('layouts.footer')
  @stack('script')
  <script src="{{ asset('tamplate/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>