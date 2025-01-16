<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid px-5">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav nav-underline me-auto mb-2 mb-lg-0 mx-auto">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('barang') ? 'active border-bottom' : '' }}" 
                       href="{{ route('barang') }}" id="barang-tab">Barang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('peminjaman') ? 'active border-bottom' : '' }}" 
                       href="{{ route('peminjaman.index') }}" id="peminjaman-tab">Peminjaman</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('riwayat') ? 'active border-bottom' : '' }}" 
                       href="{{ route('riwayat') }}" id="riwayat-tab">Riwayat</a>
                </li>
            </ul>

            <form method="GET" class="d-flex position-relative">
                <input type="text" name="search" id="search" placeholder="Cari..." class="rounded-3 border-primary form-control me-2">
            </form>
        </div>
    </div>
</nav>
