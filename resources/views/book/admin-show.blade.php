@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
<section class="main-content">
  <div class="container">
    <div class="row">
      <!-- book Images -->
      <div class="col-md-6">
        <div id="book-images" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->name }}">
            </div>
          </div>
        </div>
      </div>

      <!-- book Details -->
      <div class="col-md-6">
        <div class="book-detail mt-6 mt-md-0">
          <h1 class="mb-1">{{ $book->judul }}</h1>
          <hr class="my-6">
          <div class="book-info">
            <table class="table table-borderless mb-0">
              <tbody>
                <tr>
                  <td>Category:</td>
                  <td>{{ $book->category->name }}</td>
                </tr>
                <tr>
                  <td>Penulis:</td>
                  <td>{{ $book->penulis }}</td>
                </tr>
                <tr>
                  <td>Tahun Terbit:</td>
                  <td>{{ $book->tahun_terbit }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- book Description -->
    <div class="row">
      <div class="book-description pt-5">
        <div class="tab-content">
          <div class="tab-pane fade show active p-3">
            <h4>Deskripsi Buku</h4>
            <p>{{ $book->deskripsi ? $book->deskripsi : '-' }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
