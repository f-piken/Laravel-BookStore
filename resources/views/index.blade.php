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
  <div class="container menu-wrapper fixed-top d-none d-lg-block">
    <div class="menu d-flex justify-content-center align-items-center">
        <a class="nav-link active" href="{{ route('home') }}">Home</a>
        <a class="nav-link" href="{{ route('best.seller') }}">Best Seller</a>
        <a class="nav-link" href="{{ route('home.categories') }}">Category</a>
        <a class="nav-link" href="{{ url('/blog') }}">Blog</a>
    </div>
  </div>
  
  @include('layouts.carousel')

  <!-- Popular -->
  <section class="popular">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-6">
          <h1>Best Seller</h1>
        </div>
        <div class="col-6 text-end">
          <a href="{{ route('best.seller') }}" class="btn-first">View All</a>
        </div>
      </div>
      @include('layouts.best')
    </div>
  </section>

  <!-- Latest -->
  <section class="latest">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-6">
          <h1>Top Rate</h1>
        </div>
        <div class="col-6 text-end">
          <a href="{{ route('top.rate') }}" class="btn-first">View All</a>
        </div>
      </div>
      @include('layouts.popular')
    </div>
  </section>

  @include('layouts.sub')
  @include('layouts.footer')
  <script src="{{ asset('tamplate/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>