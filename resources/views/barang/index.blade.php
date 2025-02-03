<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>
    @include('partials.navbar')
        <div id="layoutSidenav_content" class="ms-4 overflow-hidden">
            <main>
                @if (session('success'))
                    <div class="alert alert-success w-auto me-4 mt-3 fade show d-flex justify-content-between">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    @if ($errors->any())
                    <script>
                        alert("{{ session('errors')->first() }}");
                    </script>
                    @endif

            <div class="mt-3">
                <h1><center>Daftar Barang</center></h1>
            </div>

            @php
                $totalBarang = \App\Models\Barang::sum('stok');
                $totalKeluar = \App\Models\Barang::sum('jumlah_keluar');
            @endphp
            <div class="row d-flex justify-content-center text-center mt-3">
                <div class="col-sm-4">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Jumlah Barang Tersedia</h5>
                      <p class="card-text">{{ $totalBarang }} </p>
                    </div>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="card" onclick="window.location='{{ route('riwayat') }}'">
                    <div class="card-body">
                      <h5 class="card-title">Jumlah Barang Keluar</h5>
                      <p class="card-text">{{ $totalKeluar }}</p>
                    </div>
                  </div>
                </div>
              </div>

            <button type="button" class="btn btn-primary mt-2 mb-2" data-bs-toggle="modal" data-bs-target="#tambahBarangModal">
                <i class="fa-solid fa-plus"></i>
                Tambah Barang
            </button>

                <div class="modal fade" id="tambahBarangModal" tabindex="-1" aria-labelledby="tambahBarangModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahBarangModalLabel">Tambah Data Barang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('barang.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>

                                <div class="mb-3">
                                    <label for="jenis" class="form-label">Jenis</label>
                                    <select class="form-select" id="inputGroupSelect02" name="jenis">
                                    <option value="Laptop">Laptop</option>
                                    <option value="Kamera">Kamera</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="stok" class="form-label">Stok</label>
                                    <input type="number" class="form-control" id="stok" name="stok" required>
                                </div>

                                <button type="submit" class="btn btn-primary" name="submit">Tambah</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="container-fluid">
                    <table class="table table-borderless text-center" id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Jenis</th>
                                <th>Stok</th>
                                <th>Jumlah Keluar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                <tbody>
                    @php
                        $no = $data->firstItem(); 
                    @endphp
                    @forelse ($data as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->jenis }}</td>
                            <td>
                                @if($item->stok > 0)
                                    {{ $item->stok }}
                                @else
                                    <p class="text-danger fw-bold">Kosong</p>
                                @endif
                            </td>
                            <td>{{ $item->jumlah_keluar }}</td>
                            <td class="d-flex justify-content-center align-items-center">
                                <div class="d-flex gap-2">
                                    
                                    <button type="button" class="btn btn-success d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#ubahBarangModal{{ $item->id }}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                            
                                    <form action="{{ route('barang.delete', ['id'=>$item->id]) }}" method="post" onsubmit="return confirm('yakin akan menghapus data ini?')">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger d-flex align-items-center">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            
                            
                            <div class="modal fade" id="ubahBarangModal{{ $item->id }}" tabindex="-1" aria-labelledby="ubahBarangModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ubahBarangModalLabel">Ubah Data Barang</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('barang.update', ['id'=>$item->id]) }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('put')
                                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                                    <input type="hidden" name="gambarLama" value="{{ $item->gambar }}">
                            
                                                    <div class="mb-3">
                                                        <label for="nama" class="form-label">Nama</label>
                                                        <input type="text" class="form-control" id="nama" name="nama" required value="{{ $item->nama }}">
                                                    </div>
                            
                                                    <div class="mb-3">
                                                        <label for="jenis" class="form-label">Jenis</label>
                                                        <select class="form-select" id="jenis" name="jenis">
                                                            @foreach(['Laptop', 'Kamera'] as $jenis)
                                                                <option value="{{ $jenis }}" {{ $item->jenis == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                
                                                    <div class="mb-3">
                                                        <label for="stok" class="form-label">Stok</label>
                                                        <input type="number" class="form-control" id="stok" name="stok" required value="{{ $item->stok }}">
                                                    </div>
                            
                                                    <button type="submit" class="btn btn-primary" name="submit">Ubah</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada barang</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            <div class="me-5 mt-4">{{ $data->links() }}</div>
        </div>
    </main>
        
            <footer>
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js">
    </script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js"></script>
</body>

</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#search').on('keyup', function() {
            let query = $(this).val(); 

            $.ajax({
                url: '{{ route('barang.search') }}',  
                method: 'GET',  
                data: { search: query },  
                success: function(response) {
                    $('#datatablesSimple').html(response);
                }
            });
        });
    });
</script>