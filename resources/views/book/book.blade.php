@extends('layouts.landing')

@section('title', 'books')
@section('page', 'books')

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
      <section class="col-lg-9 col-md-12 books">
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
                <p class="mb-0"><span class="text-dark">{{ $books->total() }}</span> books found</p>
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
              </div>
            </div>
          </form>
        </div>
        <div class="row">
          @if ($books->isEmpty())
                  <div class="col-12">
                    <div class="alert alert-warning text-center">
                      <strong>No books found</strong> for your search query.
                    </div>
                  </div>
                @else
                  @foreach ($books as $product)
                    <div class="col-lg-3 col-6">
                      <div class="card card-product card-body p-lg-4 p3">
                        <a href="{{ route('book.show', $product->id) }}">
                          <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
                        </a>
                        <h3 class="product-name mt-3">{{ $product->judul }}</h3>
                        <div class="detail d-flex justify-content-between align-items-center mt-4">
                          <div>
                            <p class="price">{{ $product->penulis }}</p>
                            <p class="price">{{ $product->tahun_terbit }}</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                @endif
              </div>
              @if ($books->hasPages())
                <div class="row mt-5">
                  <div class="col-12">
                    {{ $books->links() }}
                  </div>
                </div>
              @endif
        </div>
      </section>
    </div>
  </div>
</section>
@endsection