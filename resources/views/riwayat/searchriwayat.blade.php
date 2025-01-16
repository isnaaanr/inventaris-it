@if($peminjamans->isEmpty())
    <div class="text-center mt-3">
        <p class="text-danger fw-bold">Pencarian tidak ditemukan.</p>
    </div>
@else
@foreach($peminjamans as $peminjaman)
    <div class="card w-100 mb-3 mt-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title">{{ $peminjaman->keperluan }}</h5>
                <p class="card-text">Tanggal Peminjaman: {{ $peminjaman->tanggal_peminjaman }}</p>
                <p class="card-text">
                    @if($peminjaman->tanggal_kembali)
                        Tanggal Kembali: {{ $peminjaman->tanggal_kembali }}
                    @else
                        <span class="text-danger fw-bold">Belum Dikembalikan</span>
                    @endif
                </p>
            </div>
            <div class="d-flex flex-row">
                <button type="button" class="btn btn-primary me-3 mt-2" data-bs-toggle="modal" data-bs-target="#peminjamanModal{{ $peminjaman->id }}">
                    Detail
                </button>
                <form action="{{ route('riwayat.hapus', $peminjaman->id) }}?section=riwayat-section" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger mt-2" onclick="return confirm('Yakin ingin menghapus riwayat ini?')">Hapus</button>
                </form>
            </div>
        </div>
    </div>
@endforeach
@endif