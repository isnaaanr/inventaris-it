<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="sb-nav-fixed">
    @include('partials.navbar')
    <div class="container">
        <div class="mt-3">
            <h1><center>Riwayat Peminjaman</center></h1>
        </div>

        <ul class="nav nav-tabs mt-3">
          <li class="nav-item">
              <a class="nav-link" id="sedang-proses-tab" href="javascript:void(0);" onclick="showSection('sedang-proses-section')">Sedang proses</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" id="riwayat-tab2" href="javascript:void(0);" onclick="showSection('riwayat-section')">Riwayat</a>
          </li>
        </ul>

        <div id="sedang-proses-section" class="mt-3">
        <h2>Sedang Proses</h2>
        @if($peminjamans->where('tanggal_kembali', null)->isEmpty())
            <p>Tidak ada peminjaman yang sedang berjalan.</p>
        @else

        @foreach($peminjamans->where('tanggal_kembali', null) as $peminjaman)
        <div class="card w-100 mb-3 mt-3 pe-auto" data-bs-toggle="modal" data-bs-target="#peminjamanModal{{ $peminjaman->id }}">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title">{{ $peminjaman->keperluan }}</h5>
                    <p class="card-text">Tanggal Peminjaman: {{ $peminjaman->tanggal_peminjaman }}</p>
                    <p class="card-text text-danger fw-bold">Belum Dikembalikan</p>
                </div>


                <div class="d-flex flex-row">
                    <button type="button" class="btn btn-primary me-3 mt-2" data-bs-toggle="modal" data-bs-target="#peminjamanModal{{ $peminjaman->id }}">
                        Detail
                    </button>
                </div>
            </div>
        </div>


        <div class="modal fade" id="peminjamanModal{{ $peminjaman->id }}" tabindex="-1" aria-labelledby="peminjamanModalLabel{{ $peminjaman->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="peminjamanModalLabel{{ $peminjaman->id }}">Detail Peminjaman</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Keperluan:</strong> {{ $peminjaman->keperluan }}</p>
                        <p><strong>Tempat:</strong> {{ $peminjaman->tempat }}</p>
                        <p><strong>Tanggal Peminjaman:</strong> {{ $peminjaman->tanggal_peminjaman }}</p>
                        <p><strong>Tanggal Kembali:</strong> 
                            @if ($peminjaman->tanggal_kembali)
                                {{ $peminjaman->tanggal_kembali }}
                            @else
                                <span class="text-danger fw-bold">Belum Dikembalikan</span>
                            @endif
                        </p>
                        <h4>Barang yang Dipinjam:</h4>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Jumlah Dipinjam</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($peminjaman->keranjang as $keranjang)
                                        <tr>
                                            <td>{{ $keranjang->barang->nama }}</td>
                                            <td>{{ $keranjang->jumlah_peminjaman }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        <div class="d-flex">
                            @if (is_null($peminjaman->tanggal_kembali))
                                <form action="{{ route('riwayat.pengembalian', $peminjaman->id) }}" method="GET" onsubmit="return confirm('Yakin ingin menyelesaikan peminjaman ini?')">
                                    @csrf
                                    <button type="submit" class="btn btn-primary mt-3 me-3">Kembalikan</button>
                                </form>
                            @endif
                            <a href="{{ route('riwayat.cetak-pdf', $peminjaman->id) }}" class="btn btn-success mt-3">Cetak PDF</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>

    <div id="riwayat-section" class="mt-3 d-none">
        <h2>Riwayat</h2>
        @if($peminjamans->where('tanggal_kembali', '!=', null)->isEmpty())
            <p>Tidak ada riwayat peminjaman.</p>
        @else
        @foreach($peminjamans->where('tanggal_kembali', '!=', null) as $peminjaman)
            <div class="card w-100 mb-3 mt-3 pe-auto">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">{{ $peminjaman->keperluan }}</h5>
                        <p class="card-text">Tanggal Peminjaman: {{ $peminjaman->tanggal_peminjaman }}</p>
                        <p class="card-text">Tanggal Kembali: {{ $peminjaman->tanggal_kembali }}</p>
                    </div>

                    <div class="d-flex flex-row">
                        <button type="button" class="btn btn-primary me-3 mt-2" data-bs-toggle="modal" data-bs-target="#peminjamanModal{{ $peminjaman->id }}">
                            Detail
                        </button>
                        <form action="{{ route('riwayat.delete', $peminjaman->id) }}?section=riwayat-section" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger mt-2" onclick="return confirm('Yakin ingin menghapus riwayat ini?')">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
            
    

            
            <div class="modal fade" id="peminjamanModal{{ $peminjaman->id }}" tabindex="-1" aria-labelledby="peminjamanModalLabel{{ $peminjaman->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="peminjamanModalLabel{{ $peminjaman->id }}">Detail Peminjaman</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Keperluan:</strong> {{ $peminjaman->keperluan }}</p>
                            <p><strong>Tempat:</strong> {{ $peminjaman->tempat }}</p> 
                            <p><strong>Tanggal Peminjaman:</strong> {{ $peminjaman->tanggal_peminjaman }}</p>
                            <p><strong>Tanggal Kembali:</strong> 
                                @if ($peminjaman->tanggal_kembali)
                                    {{ $peminjaman->tanggal_kembali }}
                                @else
                                    <span class="text-danger fw-bold">Belum Dikembalikan</span>
                                @endif
                            </p>
                            <h4>Barang yang Dipinjam:</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th>Jumlah Dipinjam</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($peminjaman->keranjang as $keranjang)
                                            <tr>
                                                <td>{{ $keranjang->barang->nama }}</td>
                                                <td>{{ $keranjang->jumlah_peminjaman }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="d-flex">
                                @if (is_null($peminjaman->tanggal_kembali))
                                    <form action="{{ route('riwayat.pengembalian', $peminjaman->id) }}" method="GET" onsubmit="return confirm('Yakin ingin menyelesaikan peminjaman ini?')">
                                        @csrf
                                        <button type="submit" class="btn btn-primary mt-3 me-3">Kembalikan</button>
                                    </form>
                                @endif
                                <a href="{{ route('riwayat.cetak-pdf', $peminjaman->id) }}" class="btn btn-success mt-3">Cetak PDF</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
    


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>  

    <script>
        function showSection(section) {
            var sections = ['sedang-proses-section', 'riwayat-section'];
            sections.forEach(function(sec) {
                document.getElementById(sec).classList.toggle('d-none', sec !== section);
                document.getElementById(sec).classList.toggle('d-block', sec === section);

            });

            document.getElementById('sedang-proses-tab').classList.remove('active', 'text-white', 'bg-primary');
            document.getElementById('riwayat-tab2').classList.remove('active', 'text-white', 'bg-primary');

            if (section === 'sedang-proses-section') {
                document.getElementById('sedang-proses-tab').classList.add('active', 'text-white', 'bg-primary');
            } else {
                document.getElementById('riwayat-tab2').classList.add('active', 'text-white', 'bg-primary');
              }
          }

            window.onload = function () {
                showSection('sedang-proses-section');
              };

            $(document).ready(function() {
            $('#search').on('keyup', function() {
                let query = $(this).val();
                let section = $('.nav-tabs .active').attr('id') === 'sedang-proses-tab' 
                            ? 'sedang-proses-section' 
                            : 'riwayat-section';

                if (query === "") {
                    window.location.reload(); 
                    return;
                }
                
                $.ajax({
                    url: '{{ route('riwayat.search') }}',
                    method: 'GET',
                    data: { search: query, section: section },
                    success: function(response) {
                        $('#' + section).html('<h2>' + (section === 'sedang-proses-section' ? 'Sedang Proses' : 'Riwayat') + '</h2>' + response);
                    }
                });
            });
        });

  </script>
</body>
</html>