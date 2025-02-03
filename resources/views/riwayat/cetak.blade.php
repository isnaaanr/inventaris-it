<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Peminjaman</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 10px; text-align: left; }
        span { color: red; font-weight: bold;}
    </style>
</head>
<body>
    <h2>Detail Peminjaman</h2>
    <p><strong>Nama Peminjam:</strong> {{ $peminjaman->nama_peminjam }}</p>
    <p><strong>Unit:</strong> {{ $peminjaman->unit }}</p>
    <p><strong>Keperluan:</strong> {{ $peminjaman->keperluan }}</p>
    <p><strong>Tempat:</strong> {{ $peminjaman->tempat }}</p>
    <p><strong>Tanggal Peminjaman:</strong> {{ $peminjaman->tanggal_peminjaman }}</p>
    <p><strong>Tanggal Kembali:</strong> 
        @if($peminjaman->tanggal_kembali)
            {{ $peminjaman->tanggal_kembali }}
        @else
            <span>Belum Dikembalikan</span>
        @endif
    </p>

    <h4>Barang yang Dipinjam:</h4>
    <table>
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Jumlah Dipinjam</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjaman->keranjang as $keranjang)
                <tr>
                    <td>{{ $keranjang->barang->nama }}</td>
                    <td>{{ $keranjang->jumlah_peminjaman }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
