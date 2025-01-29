@extends('layouts.landing')

@section('title', 'Products')
@section('page', 'Products')

@section('content')
<section class="main-content">
  <div class="container">
    <div class="row">
      <aside class="col-lg-3 col-md-4 mb-6 mb-md-0">
        <div class="sidebar">
          <div class="sidebar-widget">
            <div class="widget-title">
              <h5>Categories</h5>
            </div>
            <div class="widget-content widget-categories">
              <ul class="nav nav-category">
                @foreach ($categories as $category)
                <li class="nav-item border-bottom w-100">
                  <a class="nav-link active" aria-current="page" href="{{ route('home.categories') }}">{{ $category->name }}<i class='bx bx-chevron-right'></i></a>
                </li>
                @endforeach
              </ul>                  
            </div>
          </div>
        </div>
      </aside>
      <section class="col-lg-9 col-md-12 products">
        <div class="card mb-4 bg-light border-0 section-header">
          <div class="card-body p-5">
            <h2 class="mb-0">Search Results</h2>
            <p class="mt-2">Showing results for: <strong>{{ request('query') }}</strong></p>
          </div>
        </div>
        <div class="row">
          <form method="GET" action="">
            <input type="hidden" name="query" value="{{ request('query') }}">
            <div class="d-lg-flex justify-content-between align-items-center">
              <div class="mb-3 mb-lg-0">
                <p class="mb-0"><span class="text-dark">{{ $products->total() }}</span> Products found</p>
              </div>
              <div class="d-flex mt-2 mt-lg-0">
                <div class="me-2 flex-grow-1">
                  <!-- Select option for pagination -->
                  <select class="form-select" name="limit" onchange="this.form.submit()">
                    <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>Show: 50</option>
                    <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ request('limit') == 20 ? 'selected' : '' }}>20</option>
                    <option value="30" {{ request('limit') == 30 ? 'selected' : '' }}>30</option>
                  </select>
                </div>
                <div>
                  <!-- Select option for sorting -->
                  <select class="form-select" name="sort" onchange="this.form.submit()">
                    <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Sort by: Featured</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="release_date" {{ request('sort') == 'release_date' ? 'selected' : '' }}>Release Date</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Avg. Rating</option>
                  </select>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="row">
          @if ($products->isEmpty())
                  <div class="col-12">
                    <div class="alert alert-warning text-center">
                      <strong>No products found</strong> for your search query.
                    </div>
                  </div>
                @else
                  @foreach ($products as $product)
                    <div class="col-lg-3 col-6">
                      <div class="card card-product card-body p-lg-4 p3">
                        <a href="{{ route('product.show', $product->id) }}">
                          <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
                        </a>
                        <h3 class="product-name mt-3">{{ $product->name }}</h3>
                        <div class="rating">
                          @for ($i = 1; $i <= 5; $i++)
                            <i class="{{ $i <= $product->rate ? 'bx bxs-star' : 'bx bx-star' }}"></i>
                          @endfor
                        </div>
                        <div class="detail d-flex justify-content-between align-items-center mt-4">
                          <p class="price">IDR {{ number_format($product->price, 0, ',', '.') }}</p>
                          <a href="{{ route('product.show', $product->id) }}" class="btn-cart">
                            <i class="bx bx-cart-alt"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  @endforeach
                @endif
              </div>
              @if ($products->hasPages())
                <div class="row mt-5">
                  <div class="col-12">
                    {{ $products->links() }}
                  </div>
                </div>
              @endif
        </div>
      </section>
    </div>
  </div>
</section>
@endsection