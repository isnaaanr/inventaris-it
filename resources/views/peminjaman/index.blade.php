<x-app-layout>
    <div id="layoutSidenav_content" class="ms-4">
        <main>
            @if (session('success'))
            <div class="bg-green-500 text-white px-2 py-1 rounded-md shadow-sm mb-2 flex justify-between items-center" role="alert">
                <span>{{ session('success') }}</span>
                <button type="button" class="text-white hover:text-gray-200" onclick="this.parentElement.style.display='none'">
                    &times;
                </button>
            </div>
            @endif

            @if ($errors->any())
            <div class="bg-red-500 text-white px-2 py-1 rounded-md shadow-sm mb-2 flex justify-between items-center" role="alert">
                <ul class="text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="text-white hover:text-gray-200" onclick="this.parentElement.style.display='none'">
                    &times;
                </button>
            </div>
            @endif

            <div class="container mx-auto px-2">

                <div class="flex space-x-4 mb-4">
                    <!-- Form Input Kiri -->
                    <div class="flex-1">
                        <div class="card shadow-lg rounded-md p-3 bg-white h-full">
                            <h1 class="text-md font-semibold text-gray-800 text-center mb-2">Peminjaman Barang</h1>
                
                            <form id="addProductForm" class="space-y-3">
                                <div>
                                    <label for="namaBarang" class="text-sm font-semibold text-gray-700">Nama Barang</label>
                                    <input type="text" id="namaBarang" class="w-full px-2 py-1 border border-gray-300 rounded-md text-sm" placeholder="Masukkan nama barang" required>
                                    <input type="hidden" id="barangId">
                                    <div id="suggestionsBarang" class="absolute w-2/5 bg-white border border-gray-300 rounded-md shadow-lg z-10 hidden overflow-y-auto max-h-40"></div>
                                </div>
                
                                <div>
                                    <label for="jumlahBarang" class="text-sm font-semibold text-gray-700">Jumlah Barang</label>
                                    <input type="number" id="jumlahBarang" class="w-full px-2 py-1 border border-gray-300 rounded-md text-sm" min="1" placeholder="Masukkan jumlah barang" required>
                                </div>
                
                                <button type="submit" class="w-full py-1 bg-blue-600 text-white text-sm font-semibold rounded-md hover:bg-blue-700">Tambah Barang</button>
                            </form>
                        </div>
                    </div>
                
                    <!-- Tabel Kanan -->
                    <div class="flex-1 h-full">
                        <div class="card shadow-lg rounded-md p-3 bg-white h-full">
                            <table class="min-w-full text-xs" id="tabel-hasil">
                                <thead class="bg-indigo-600 text-white">
                                    <tr>
                                        <th class="px-2 py-1">No</th>
                                        <th class="px-2 py-1">Nama Barang</th>
                                        <th class="px-2 py-1">Jenis</th>
                                        <th class="px-2 py-1">Jumlah</th>
                                        <th class="px-2 py-1">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white text-gray-800">
                                    @php
                                        $keranjang = session()->get('keranjang', []);
                                    @endphp
                                    @if(empty($keranjang))
                                    <tr>
                                        <td colspan="5" class="text-center px-2 py-1 text-gray-400">Tidak ada item</td>
                                    </tr>
                                    @else
                                    @foreach($keranjang as $id => $jumlah)
                                        @php
                                            $item = \App\Models\Barang::find($id);
                                        @endphp
                                        <tr class="border-b">
                                            <td class="px-2 py-1 text-center">{{ $loop->iteration }}</td>
                                            <td class="px-2 py-1 text-center">{{ $item->nama }}</td>
                                            <td class="px-2 py-1 text-center">{{ $item->jenis }}</td>
                                            <td class="px-2 py-1 text-center">
                                                <input type="number" value="{{ $keranjang[$item->id] }}" min="1" onchange="updateJumlah('{{ $id }}', this.value)" class="w-14 px-2 py-1 border border-gray-300 rounded-md text-xs">
                                            </td>
                                            <td class="px-2 py-1 text-center">
                                                <form action="{{ route('peminjaman.remove', $id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-2 py-1 bg-red-600 text-white text-xs font-semibold rounded-md hover:bg-red-700">Hapus</button>
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
                

                

                <!-- Form Keperluan -->
                <div class="card shadow-sm rounded-md p-3 bg-white">
                    <form action="{{ route('peminjaman.checkout') }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <label for="keperluan" class="text-sm font-semibold text-gray-700">Keperluan</label>
                            <input type="text" class="w-full px-2 py-1 border border-gray-300 rounded-md text-sm" id="keperluan" name="keperluan" required>
                        </div>
                        <div>
                            <label for="tempat" class="text-sm font-semibold text-gray-700">Tempat</label>
                            <input type="text" class="w-full px-2 py-1 border border-gray-300 rounded-md text-sm" id="tempat" name="tempat" required>
                        </div>
                        <div>
                            <label for="tanggal" class="text-sm font-semibold text-gray-700">Tanggal Penggunaan</label>
                            <input type="date" class="w-full px-2 py-1 border border-gray-300 rounded-md text-sm" id="tanggal" name="tanggal" required>
                        </div>
                        <button type="submit" class="w-full py-1 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700">Pinjam Barang</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>



        
    
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    $(document).ready(function(){
    let selectedIndex = -1;

    $('#namaBarang').on('input', function(){
        let query = $(this).val();
        if(query.length > 1) {
            $.ajax({
                url: '{{ route('barang.autocomplete') }}',
                type: 'GET',
                data: { query: query },
                success: function(data) {
                    let suggestions = $('#suggestionsBarang');
                    suggestions.empty().show();
                    data.forEach(function(item) {
                        suggestions.append(`
                            <div class="px-3 py-2 bg-white hover:bg-gray-100 cursor-pointer border-b border-gray-300 text-sm text-gray-700 list-group-item list-group-item-action" data-id="${item.id}">${item.nama}</div>`);
                    });

                    selectedIndex = -1;
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
                        // Menambahkan row baru dengan Tailwind CSS
                        let newRow = `
                            <tr id="row-${response.id}" class="border-b">
                                <td class="px-2 py-1 text-center">${response.itemNo}</td>
                                <td class="px-2 py-1 text-center">${response.namaBarang}</td>
                                <td class="px-2 py-1 text-center">${response.jenis}</td>
                                <td class="px-2 py-1 text-center">
                                    <input type="number" value="${response.jumlahBarang}" min="1" onchange="updateJumlah(${response.id}, this.value)" class="w-12 px-2 py-1 border border-gray-300 rounded-md text-xs">
                                </td>
                                <td class="px-2 py-1 text-center">
                                    <form action="/peminjaman/remove/${response.id}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 bg-red-600 text-white text-xs font-semibold rounded-md hover:bg-red-700">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        `;
                        $('#tabel-hasil tbody').append(newRow);
                    }

                    $('#namaBarang').val('');
                    $('#jumlahBarang').val('');
                    $('#suggestionsBarang').empty();
                    $('#tabel-hasil tbody').find('tr:contains("Tidak ada item")').remove();
                } else {
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