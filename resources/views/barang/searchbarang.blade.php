<thead>
    <tr>
        <th>No</th>
        <th>Nama Barang</th>
        <th>Jenis</th>
        <th>Stok</th>
        <th>Aksi</th>
    </tr>
</thead>

<tbody>
@php
    $no = $data->firstItem(); 
@endphp
@forelse ($data as $item)
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->nama }}</td>
        <td>{{ $item->jenis }}</td>
        <td>
            @if($item->stok > 0)
                {{ $item->stok }}
            @else
                <p class="text-danger fw-bold">Kosong</p>
            @endif
        </td>
        <td class="d-flex justify-content-center align-items-center">
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ubahBarangModal{{ $item->id }}">
                    <i class="fa-solid fa-pen-to-square"></i>
                </button>

                <form action="{{ route('barang.delete', ['id'=>$item->id]) }}" method="post" onsubmit="return confirm('yakin akan menghapus data ini?')">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </form>
            </div>
        </td>
    </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center fw-bold text-danger">Pencarian tidak ditemukan.</td>
        </tr>
    </tbody>
@endforelse
