@extends('layouts.landing') <!-- Gunakan layout yang sesuai, seperti 'app.blade.php' -->

@section('title', 'Wish List')
@section('page', 'Wish List')

@section('content')
  <!-- Popular -->
<section class="">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-6">
          <h1>Wish List</h1>
        </div>
      </div>
      <div class="row">
        @foreach ($wish as $item)
        <div class="col-lg-3 col-6">
          <div class="card card-product card-body p-lg-4 p3">
            <a href="{{ route('product.show', $item->product->id) }}">
              <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="img-fluid">
            </a>
            <h3 class="product-name mt-3">{{ $item->product->name }}</h3>
            <div class="rating">
              @for ($i = 1; $i <= 5; $i++)
                <i class="bx {{ $i <= $item->product->rate ? 'bxs-star' : 'bx-star' }}"></i>
              @endfor
            </div>
            <div class="detail d-flex justify-content-between align-items-center mt-4">
              <p class="price">IDR {{ number_format($item->product->price, 0, ',', '.') }}</p>
              <a href="product.html" class="btn-cart"><i class="bx bx-cart-alt"></i></a>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
</section>
@endsection