<x-app-layout>
    <div id="layoutSidenav_content" class="ms-4">
        <main>
            @if (session('success'))
            <div class="bg-green-500 text-white px-4 py-2 rounded-md mb-3 flex justify-between items-center font-semibold max-w-md mx-auto shadow-md" role="alert">
                <span>{{ session('success') }}</span>
                <button type="button" class="text-white hover:text-gray-300" onclick="this.parentElement.style.display='none'">
                    &times;
                </button>
            </div>
            
            @endif
    
            @if ($errors->any())
            <div class="bg-red-500 text-white px-4 py-3 rounded-md mb-3 flex justify-between items-start font-semibold max-w-md mx-auto shadow-md" role="alert">
                <ul class="text-xs space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="text-white hover:text-gray-300" onclick="this.parentElement.style.display='none'">
                    &times;
                </button>
            </div>            
            @endif
    
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-3 gap-4">
                    <!-- Form Input -->
                    <div class="col-span-1 space-y-4">
                        <div class="border-2 border-gray-400 rounded-lg p-5 bg-white">
                            <h1 class="text-lg font-bold text-gray-800 text-center mb-3">Peminjaman Barang</h1>
                            <form id="addProductForm" class="space-y-3">
                                <div>
                                    <label for="namaBarang" class="text-sm font-bold text-gray-700">Nama Barang</label>
                                    <input type="text" id="namaBarang" class="w-full px-3 py-2 border border-gray-400 rounded-md text-sm font-medium" placeholder="Masukkan nama barang" required>
                                    <input type="hidden" id="barangId">
                                    <div id="suggestionsBarang" class="absolute w-1/5 bg-white border border-gray-400 rounded-md z-10 hidden overflow-y-auto max-h-40"></div>
                                </div>
                                <div>
                                    <label for="jumlahBarang" class="text-sm font-bold text-gray-700">Jumlah Barang</label>
                                    <input type="number" id="jumlahBarang" class="w-full px-3 py-2 border border-gray-400 rounded-md text-sm font-medium" min="1" placeholder="Masukkan jumlah barang" required>
                                </div>
                                <button type="submit" class="w-full py-2 bg-blue-700 text-white text-sm font-bold rounded-md hover:bg-blue-800">Tambah Barang</button>
                            </form>
                        </div>
    
                        <div class="border-2 border-gray-400 rounded-lg p-5 bg-white">
                            <h1 class="text-lg font-bold text-gray-800 text-center mb-3">Detail Peminjaman</h1>
                            <form action="{{ route('peminjaman.checkout') }}" method="POST" class="space-y-3">
                                @csrf
                                <div>
                                    <label for="nama_peminjam" class="text-sm font-bold text-gray-700">Nama Peminjam</label>
                                    <input type="text" class="w-full px-3 py-2 border border-gray-400 rounded-md text-sm font-medium" id="nama_peminjam" name="nama_peminjam" required>
                                </div>
                                <div>
                                    <label for="unit" class="text-sm font-bold text-gray-700">Unit</label>
                                    <input type="text" class="w-full px-3 py-2 border border-gray-400 rounded-md text-sm font-medium" id="unit" name="unit" required>
                                </div>
                                <div>
                                    <label for="keperluan" class="text-sm font-bold text-gray-700">Keperluan</label>
                                    <input type="text" class="w-full px-3 py-2 border border-gray-400 rounded-md text-sm font-medium" id="keperluan" name="keperluan" required>
                                </div>
                                <div>
                                    <label for="tempat" class="text-sm font-bold text-gray-700">Tempat</label>
                                    <input type="text" class="w-full px-3 py-2 border border-gray-400 rounded-md text-sm font-medium" id="tempat" name="tempat" required>
                                </div>
                                <div>
                                    <label for="tanggal" class="text-sm font-bold text-gray-700">Tanggal Penggunaan</label>
                                    <input type="date" class="w-full px-3 py-2 border border-gray-400 rounded-md text-sm font-medium" id="tanggal" name="tanggal" required>
                                </div>
                                <button type="submit" class="w-full py-2 bg-indigo-700 text-white text-sm font-bold rounded-md hover:bg-indigo-800">Pinjam Barang</button>
                            </form>
                        </div>
                    </div>
    
                    <!-- Tabel Kanan -->
                    <div class="col-span-2 h-full">
                        <div class="border-2 border-gray-400 rounded-lg p-5 bg-white h-full">

                            <!-- Input Pencarian -->      
                            <div class="flex justify-between items-center mb-4">
                                <h1 class="text-lg font-semibold text-gray-800">Daftar Barang Dipinjam</h1>
                                <input type="text" id="searchTable" 
                                    class="border w-72 border-gray-300 rounded-md p-2 text-sm focus:ring-1 focus:ring-blue-400 focus:border-blue-400 transition duration-150 ease-in-out text-center" 
                                    placeholder="Cari barang...">
                            </div>
                            
                            <div class="overflow-y-auto max-h-[500px]">
                                <table class="min-w-full text-xs border border-gray-400 rounded-md" id="tabel-hasil">
                                    <thead class="bg-indigo-700 text-white">
                                        <tr>
                                            <th class="px-4 py-2">No</th>
                                            <th class="px-4 py-2">Nama Barang</th>
                                            <th class="px-4 py-2">Jenis</th>
                                            <th class="px-4 py-2">Jumlah</th>
                                            <th class="px-4 py-2">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white text-gray-800">
                                        @php
                                            $keranjang = session()->get('keranjang', []);
                                        @endphp
                                        @if(empty($keranjang))
                                        <tr>
                                            <td colspan="5" class="text-center px-4 py-2 text-gray-400">Tidak ada item</td>
                                        </tr>
                                        @else
                                        @foreach($keranjang as $id => $jumlah)
                                            @php
                                                $item = \App\Models\Barang::find($id);
                                            @endphp
                                            <tr class="border-b">
                                                <td class="px-4 py-2 text-center">{{ $loop->iteration }}</td>
                                                <td class="px-4 py-2 text-center nama-barang">{{ $item->nama }}</td>
                                                <td class="px-4 py-2 text-center jenis-barang">{{ $item->jenis }}</td>
                                                <td class="px-4 py-2 text-center">
                                                    <input type="number" value="{{ $keranjang[$item->id] }}" min="1" onchange="updateJumlah('{{ $id }}', this.value)" class="w-16 px-2 py-1 border border-gray-400 rounded-md text-xs font-medium">
                                                </td>
                                                <td class="px-4 py-2 text-center">
                                                    <form action="{{ route('peminjaman.remove', $id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-3 py-1 bg-red-700 text-white text-xs font-bold rounded-md hover:bg-red-800">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    
                </div>
            </div>
        </main>
    </div>
</x-app-layout>



        
    
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Pencarian barang di tabel
            $('#searchTable').on('keyup', function() {
                let value = $(this).val().toLowerCase();
                $('#tabel-hasil tbody tr').each(function() {
                    let namaBarang = $(this).find('.nama-barang').text().toLowerCase();
                    let jenisBarang = $(this).find('.jenis-barang').text().toLowerCase();
                    $(this).toggle(namaBarang.includes(value) || jenisBarang.includes(value));
                });

                let visibleRows = $('#tabel-hasil tbody tr:visible').length;
                if (visibleRows === 0) {
                    if ($('#no-results').length === 0) {
                        $('#tabel-hasil tbody').append(
                            `<tr id="no-results"><td colspan="5" class="text-center px-4 py-2 text-gray-400">Tidak ada hasil ditemukan</td></tr>`
                        );
                    }
                } else {
                    $('#no-results').remove();
                }
            });

            // Autocomplete barang
            let selectedIndex = -1;
            $('#namaBarang').on('input', function() {
                $('#barangId').val('');
                let query = $(this).val();
                if (query.length > 1) {
                    $.ajax({
                        url: '{{ route('barang.autocomplete') }}',
                        type: 'GET',
                        data: { query: query },
                        success: function(data) {
                            let suggestions = $('#suggestionsBarang');
                            suggestions.empty().show();
                            data.forEach(item => {
                                suggestions.append(`<div class="px-3 py-2 bg-white hover:bg-gray-100 cursor-pointer border-b border-gray-300 text-sm text-gray-700 list-group-item" data-id="${item.id}">${item.nama}</div>`);
                            });
                            selectedIndex = -1;
                        }
                    });
                } else {
                    $('#suggestionsBarang').empty().hide();
                }
            });

            // Navigasi keyboard di autocomplete
            $('#namaBarang').on('keydown', function(e) {
                let suggestions = $('#suggestionsBarang .list-group-item');
                if (suggestions.length > 0) {
                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        selectedIndex = (selectedIndex + 1) % suggestions.length;
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        selectedIndex = (selectedIndex - 1 + suggestions.length) % suggestions.length;
                    } else if (e.key === 'Enter') {
                        e.preventDefault();
                        if (selectedIndex > -1) {
                            let selectedItem = suggestions.eq(selectedIndex);
                            $('#namaBarang').val(selectedItem.text());
                            $('#barangId').val(selectedItem.data('id'));
                            $('#suggestionsBarang').empty().hide();
                        }
                    }
                    suggestions.removeClass('active');
                    if (selectedIndex > -1) suggestions.eq(selectedIndex).addClass('active');
                }
            });

            // Pilih barang dari autocomplete
            $(document).on('click', '.list-group-item', function() {
                $('#namaBarang').val($(this).text());
                $('#barangId').val($(this).data('id'));
                $('#suggestionsBarang').empty().hide();
            });

            // Sembunyikan autocomplete saat klik di luar
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#namaBarang, #suggestionsBarang').length) {
                    $('#suggestionsBarang').hide();
                }
            });

            // Submit form tambah barang
            $('#addProductForm').submit(function(event) {
                event.preventDefault();
                let namaBarang = $('#namaBarang').val();
                let jumlahBarang = $('#jumlahBarang').val();
                let barangId = $('#barangId').val();

                if (!barangId) {
                    alert('Silakan pilih barang dari daftar saran.');
                    return;
                }

                $.ajax({
                    url: '/peminjaman/add/' + namaBarang,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        namaBarang: namaBarang,
                        jumlahBarang: jumlahBarang
                    },
                    success: function(response) {
                        if (response.success) {
                            let existingRow = $('#tabel-hasil tbody tr').filter(function() {
                                return $(this).find('td:eq(1)').text() === response.namaBarang;
                            });

                            if (existingRow.length > 0) {
                                let currentJumlah = parseInt(existingRow.find('td:eq(3) input').val()) || 0;
                                existingRow.find('td:eq(3) input').val(currentJumlah + parseInt(response.jumlahBarang));
                            } else {
                                let newRow = `
                                    <tr id="row-${response.id}" class="border-b">
                                        <td class="px-4 py-2 text-center">${response.itemNo}</td>
                                        <td class="px-4 py-2 text-center">${response.namaBarang}</td>
                                        <td class="px-4 py-2 text-center">${response.jenis}</td>
                                        <td class="px-4 py-2 text-center">
                                            <input type="number" value="${response.jumlahBarang}" min="1" onchange="updateJumlah(${response.id}, this.value)" class="w-16 px-2 py-1 border border-gray-400 rounded-md text-xs font-medium">
                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            <form action="/peminjaman/remove/${response.id}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 bg-red-700 text-white text-xs font-bold rounded-md hover:bg-red-800">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                `;
                                $('#tabel-hasil tbody').append(newRow);
                            }

                            $('#namaBarang, #jumlahBarang').val('');
                            $('#suggestionsBarang').empty();
                            $('#tabel-hasil tbody').find('tr:contains("Tidak ada item")').remove();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });
        });

        function updateJumlah(id, jumlah) {
            if (jumlah < 1) {
                alert('Jumlah barang harus minimal 1.');
                return;
            }
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
                if (!data.success) {
                    alert(data.message);
                    location.reload();
                }
            })
            .catch(error => {
                console.error(error);
                alert('Terjadi kesalahan saat memperbarui jumlah barang.');
            });
        }

    </script>