<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="sb-nav-fixed">
    @include('partials.navbar')
        <div id="layoutSidenav_content" class="ms-4">
            <main>
                @if (session('success'))
                <div class="alert alert-success w-auto me-4 fade show d-flex justify-content-between">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger w-auto me-4 fade show d-flex justify-content-between">
                        <ul> 
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif


              <div class="container">
                <div class="mt-3">
                    <h1><center>Peminjaman Barang</center></h1>
                </div>
                  
                  <form id="addProductForm" method="POST">
                      @csrf
                      <div class="mb-3">
                        <label for="namaBarang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="namaBarang" name="namaBarang" autocomplete="off" required>
                        <input type="hidden" id="barangId" name="barangId">
                        <div id="suggestionsBarang" class="list-group position-absolute z-3"></div>
                      </div>
                      <div class="mb-3">
                          <label for="jumlahBarang" class="form-label">Jumlah</label>
                          <input type="number" min="1" class="form-control" id="jumlahBarang" name="jumlahBarang" required>
                      </div>
                      <button type="submit" class="btn btn-primary">Tambah</button>
                  </form>

                  <br>

                  <table class="table" id="tabel-hasil">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $keranjang = session()->get('keranjang', []);
                        @endphp
                        @if(empty($keranjang))
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada item</td>
                            </tr>
                        @else
                            @foreach($keranjang as $id => $jumlah)
                                @php
                                    $item = \App\Models\Barang::find($id);
                                @endphp
                                <tr id="row-${barangId}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->jenis }}</td>
                                    <td>
                                        <input type="number" value="{{ $keranjang[$item->id] }}" min="1" onchange="updateJumlah('{{ $id }}', this.value)">
                                    </td>
                                    <td>
                                        <form action="{{ route('peminjaman.remove', $id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>                                        
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    
                </table>

                  <form action="{{ route('peminjaman.checkout') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_peminjam" class="form-label">Nama Peminjam</label>
                        <input type="text" class="form-control" id="nama_peminjam" name="nama_peminjam" required>
                    </div>
                    <div class="mb-3">
                        <label for="unit" class="form-label">Unit</label>
                        <input type="text" class="form-control" id="unit" name="unit" required>
                    </div>
                    <div class="mb-3">
                        <label for="keperluan" class="form-label">Keperluan</label>
                        <input type="text" class="form-control" id="keperluan" name="keperluan" required>
                    </div>
                    <div class="mb-3">
                        <label for="tempat" class="form-label">Tempat</label>
                        <input type="text" class="form-control" id="tempat" name="tempat" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal Penggunaan</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <button type="submit" class="btn btn-primary mb-3">Pinjam Barang</button>
                </form>
              </div>
            </main>
        </div>
    

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function(){
            let selectedIndex = -1;
        $('#namaBarang').on('input', function(){
            let query = $(this).val();
            if(query.length > 1) {
                $.ajax({
                    url: '{{ route('barang.autocomplete') }}',
                    type: 'GET',
                    data: {query: query},
                    success: function(data) {
                        let suggestions = $('#suggestionsBarang');
                        suggestions.empty().show();
                        data.forEach(function(item) {
                            suggestions.append(`<div class="list-group-item list-group-item-action" data-id="${item.id}">${item.nama}</div>`);
                            selectedIndex = -1;
                        });
                    }
                });
            } else {
                $('#suggestionsBarang').empty();
            }
        });

    $('#namaBarang').on('keydown', function(e) {
        let suggestions = $('#suggestionsBarang .list-group-item');
        if (suggestions.length > 0) {
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                selectedIndex = (selectedIndex + 1) % suggestions.length;
            } 
            else if (e.key === 'ArrowUp') {
                e.preventDefault();
                selectedIndex = (selectedIndex - 1 + suggestions.length) % suggestions.length;
            } 
            else if (e.key === 'Enter') {
                e.preventDefault();
                if (selectedIndex > -1) {
                    $(this).val(suggestions.eq(selectedIndex).text());
                    $('#barangId').val(suggestions.eq(selectedIndex).data('id'));
                    $('#suggestionsBarang').empty().hide();
                }
            }
            suggestions.removeClass('active');
            if (selectedIndex > -1) {
                suggestions.eq(selectedIndex).addClass('active');
            }
        }
    });

        
        $(document).on('click', '.list-group-item', function(){
            $('#namaBarang').val($(this).text());
            $('#barangId').val($(this).data('id'));
            $('#suggestionsBarang').empty();
        });

        $(document).on('click', function(e) {
        if (!$(e.target).closest('#namaBarang, #suggestionsBarang').length) {
            $('#suggestionsBarang').hide();
        }

        
        $('#namaBarang').on('focus', function(){
            if ($('#suggestionsBarang').children().length > 1) {
                $('#suggestionsBarang').show();
            }
        });
    });


        $('#addProductForm').submit(function (event) {
            event.preventDefault();

            let namaBarang = $('#namaBarang').val();
            let jumlahBarang = $('#jumlahBarang').val();

            $.ajax({
                url: '/peminjaman/add/' + namaBarang, 
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    namaBarang: namaBarang,
                    jumlahBarang: jumlahBarang
                },
                success: function (response) {
                    if (response.success) {
                        let existingRow = $('#tabel-hasil tbody tr').filter(function () {
                            return $(this).find('td:eq(1)').text() === response.namaBarang;
                        });

                        if (existingRow.length > 0) {
                            let currentJumlah = parseInt(existingRow.find('td:eq(3) input').val()) || 0;
                            existingRow.find('td:eq(3) input').val(currentJumlah + parseInt(response.jumlahBarang));
                        } else {
                            let newRow = `<tr id="row-${barangId}">
                                <td>${response.itemNo}</td>
                                <td>${response.namaBarang}</td>
                                <td>${response.jenis}</td>
                                <td><input type="number" value="${response.jumlahBarang}" min="1" onchange="updateJumlah(${response.id}, this.value)"></td>
                                <td>
                                    <form action="/peminjaman/remove/${response.id}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>`;
                            $('#tabel-hasil tbody').append(newRow);
                        }

                        $('#namaBarang').val('');
                        $('#jumlahBarang').val('');
                        $('#suggestionsBarang').empty();
                        $('#tabel-hasil tbody').find('tr:contains("Tidak ada item")').remove();
                    }else {
                        alert(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        });
    });

    function updateJumlah(id, jumlah) {
    fetch(`/peminjaman/update/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ jumlah: jumlah })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            alert(data.message);
        } else {
            alert(data.message); 
            location.reload();  
        }
    })
    .catch(error => alert('Terjadi kesalahan saat memperbarui jumlah barang.'));
}


$(document).ready(function() {
        $('#search').on('keyup', function() {
            let query = $(this).val();  

            if (query === "") {
            window.location.reload(); 
            return;
            }
            $.ajax({
                url: '{{ route('peminjaman.search') }}',  
                method: 'GET',  
                data: { search: query },  
                success: function(response) {
                    $('#tabel-hasil').html(response);
                }
            });
            
        });
    });

</script>
</body>
</html>
