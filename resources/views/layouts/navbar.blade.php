<nav class="navbar navbar-expand-lg bg-white fixed-top py-4 shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Books<span>Library</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <form action="{{ route('book.cari') }}" method="GET" class="input-group mx-auto mt-5 mt-lg-0">
                <input type="text" name="query" class="form-control" placeholder="Mau cari apa?" aria-label="Mau cari apa?" aria-describedby="button-addon2" value="{{ request('query') }}">
                <button class="btn btn-outline-warning" type="submit" id="button-addon2">
                  <i class="bx bx-search"></i>
                </button>
              </form>              
            <ul class="navbar-nav ms-auto mt-3 mt-sm-0">
                <!-- Mobile Menu -->
                <div class="dropdown mt-3 d-lg-none">
                    <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Menu
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="{{ route('home') }}">Home</a></li>
                        <li><a class="dropdown-item" href="{{ route('home.categories') }}">Category</a></li>
                        <li><a class="dropdown-item" href="{{ url('/blog') }}">Blog</a></li>
                    </ul>
                </div>
                <li class="nav-item mt-5 mt-lg-0 text-center">
                    @guest
                        <a class="nav-link btn-second me-lg-3" href="{{ url('/login') }}">Login</a>
                    @endguest
                    @auth
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('images/default_profile.jpg') }}" alt="Profile" class="icon">
                                {{ Auth::user()->name ?? 'Guest' }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                @if (Auth::user()->role == 'viewer')
                                <li><a class="dropdown-item" href="{{ route('viewers.index') }}">Profil</a></li>
                                @elseif(Auth::user()->role == 'editor')
                                <li><a class="dropdown-item" href="{{ route('editors.index') }}">Profil</a></li>
                                <li><a class="dropdown-item" href="{{ route('editors.books') }}">Book</a></li>
                                @endif
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endauth
                </li>                
            </ul>
        </div>
    </div>
</nav>

