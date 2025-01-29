@extends('layouts.landing')

@section('title', 'Products')
@section('page', 'Product')

@section('sub')
<li class="breadcrumb-item active" aria-current="page">Products</li>
@endsection

@section('content')
<section class="main-content">
  <div class="container">
    <div class="row">
      <!-- Product Images -->
      <div class="col-md-6">
        <div id="product-images" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            </div>
          </div>
        </div>
      </div>

      <!-- Product Details -->
      <div class="col-md-6">
        <div class="product-detail mt-6 mt-md-0">
          <h1 class="mb-1">{{ $product->name }}</h1>
          <div class="mb-3 rating">
            <small class="text-warning">
              @for ($i = 1; $i <= 5; $i++)
                <i class="bx {{ $i <= floor($product->rate) ? 'bxs-star' : 'bx-star' }}"></i>
              @endfor
            </small>
            <span class="ms-2">({{ $product->rate }} rating)</span>
          </div>
          <div class="price">
            <span class="active-price text-dark">IDR {{ number_format($product->price, 0, ',', '.') }}</span>
          </div>
          <hr class="my-6">
          <div class="product-select mt-3 row justify-content-start g-3 align-items-center" style="width: 630px;">
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="col-md-5">
                @csrf
                <div class="d-flex align-items-center">
                    <input type="number" name="quantity" value="1" class="form-control" min="1" max="{{ $product->stock }}" style="width: 100px;"/>
                    <button type="submit" class="btn btn-add-cart ms-3"><i class="bx bx-cart-alt"></i> Add to cart</button>
                </div>
            </form>
        
            <form action="{{ route('wishlist.add', $product->id) }}" method="POST" class="col-md-5">
                @csrf
                <button type="submit" class="btn btn-light" data-bs-toggle="tooltip" title="Add to wishlist">
                    <i class="bx bx-heart"></i>
                </button>
            </form>
          </div>        
          <hr class="my-6">
          <div class="product-info">
            <table class="table table-borderless mb-0">
              <tbody>
                <tr>
                  <td>Category:</td>
                  <td>{{ $product->category->name }}</td>
                </tr>
                <tr>
                  <td>Seller:</td>
                  <td>{{ $product->seller->store_name }}</td>
                </tr>
                <tr>
                  <td>Stock:</td>
                  <td>{{ $product->stock }}</td>
                </tr>
                <tr>
                  <td>Sold:</td>
                  <td>{{ $product->sold }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Product Description -->
    <div class="row">
      <div class="product-description pt-5">
        <div class="tab-content">
          <div class="tab-pane fade show active p-3">
            <h4>Product Description</h4>
            <p>{{ $product->description }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
