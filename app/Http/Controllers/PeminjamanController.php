<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MpdfException;
use Mpdf\Mpdf;

class PeminjamanController extends Controller
{

    public function index()
    {
        $peminjamans = Peminjaman::with('barang')->get();
        return view('peminjaman.index', compact('peminjamans'));
    }

    public function addPeminjaman(Request $request){
        $namaBarang = $request->namaBarang;
        $barang = Barang::where('nama', $namaBarang)->first();
        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Barang tidak ditemukan.'
            ]);
        }

        $jumlahBarang = $request->jumlahBarang;
        $keranjang = session()->get('keranjang', []);
        $jumlahSaatIni = isset($keranjang[$barang->id]) ? $keranjang[$barang->id] : 0;
        $totalJumlah = $jumlahSaatIni + $jumlahBarang;
        
        if ($jumlahBarang > $barang->stok) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi. Tersedia: ' . $barang->stok
            ]);
        }

        if ($totalJumlah > $barang->stok) {
            return response()->json([
                'success' => false, 
                'message' => 'Stok tidak mencukupi! Maksimal stok yang tersedia: ' . $barang->stok
            ]);
        }
    
    
        if (isset($keranjang[$barang->id])) {
            $keranjang[$barang->id] += $jumlahBarang;
        } else {
            $keranjang[$barang->id] = $jumlahBarang;
        }
    
        session()->put('keranjang', $keranjang);
    
        return response()->json([
            'success' => true,
            'itemNo' => count($keranjang),
            'namaBarang' => $barang->nama,
            'jenis' => $barang->jenis,
            'jumlahBarang' => $jumlahBarang,
            'id' => $barang->id
        ]);
    }

    public function removeFromPeminjaman($id) {
        $keranjang = session()->get('keranjang', []);
        
        if(isset($keranjang[$id])) {
            unset($keranjang[$id]);
            session()->put('keranjang', $keranjang);
        }
    
        return redirect()->route('peminjaman.index')->with('success', 'Barang berhasil dihapus.');
    }
    

    public function checkout(Request $request) {
        $keranjang = session()->get('keranjang', []); 
        
        if (empty($keranjang)) {
            return back()->withErrors(['barang kosong' => 'Tidak ada item']);
        }
    
        $request->validate([
            'keperluan' => 'required|string|max:255',
            'tempat' => 'required|string|max:255',
            'tanggal' => 'required|date',
        ]);
    
        $keperluan = ucwords(strtolower($request->input('keperluan')));
        $tempat = ucwords(strtolower($request->input('tempat')));
        $tanggal = $request->input('tanggal');
    
        $peminjaman = Peminjaman::create([
            'keperluan' => $keperluan,
            'tempat' => $tempat,
            'tanggal_peminjaman' => $tanggal,
        ]);
    
        DB::transaction(function () use ( $keranjang, $peminjaman) {
            foreach ($keranjang as $id => $jumlah) {
                $barang = Barang::findOrFail($id);
                if ($barang->stok < $jumlah) {
                    throw new \Exception('Stok barang tidak mencukupi.');
                }
            }
    
            foreach ($keranjang as $id => $jumlah) {
                $barang = Barang::findOrFail($id);
                $barang->stok -= $jumlah;
                $barang->save();
    
                Keranjang::create([
                    'idbarang' => $id,
                    'idpeminjaman' => $peminjaman->id, 
                    'jumlah_peminjaman' => $jumlah,
                ]);
            }
        });
    
        
        session()->forget('keranjang');
    
        return redirect('/riwayat')->with('success', 'Checkout berhasil!');
    } 
    public function riwayat() {
        $peminjamans = Peminjaman::orderBy('tanggal_kembali', 'desc')->with('keranjang.barang')->get();

        return view('riwayat.index', compact('peminjamans'));
    }


    public function pengembalian($id){
    $peminjaman = Peminjaman::findOrFail($id);

    
    $peminjaman->update([
        'tanggal_kembali' => now()
    ]);

    
    foreach ($peminjaman->keranjang as $keranjang) {
        $barang = $keranjang->barang;
        $barang->stok += $keranjang->jumlah_peminjaman;
        $barang->save(); 
    }

    return redirect('/riwayat')->with('success', 'Peminjaman selesai!');
    }


    public function cetakPdf($id)
    {
        $peminjaman = Peminjaman::with('keranjang.barang')->findOrFail($id);

        $mpdf = new Mpdf();
        $html = view('riwayat.cetak', compact('peminjaman'))->render();
        $mpdf->WriteHTML($html);
        $mpdf->Output('detail_peminjaman.pdf', 'I');
    }

    public function updateJumlah(Request $request, $id) {
        $keranjang = session()->get('keranjang', []);
        $barang = Barang::findOrFail($id); 
    
        if(isset($keranjang[$id])) {
            if ($request->jumlah > $barang->stok) {
                return response()->json(['success' => false, 'message' => 'Stok tidak mencukupi. Stok tersedia: ' . $barang->stok]);
            }

            if ($request->jumlah <= 0) {
                return response()->json(['success' => false, 'message' => 'Jumlah barang tidak boleh 0']);
            }
    
            $keranjang[$id] = $request->jumlah;
            session()->put('keranjang', $keranjang);
            return response()->json(['success' => true, 'message' => 'Jumlah barang berhasil diperbarui']);
        }
        
        return response()->json(['success' => false, 'message' => 'Barang tidak ditemukan di keranjang']);
    }
        

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->delete();
        return redirect()->route('riwayat')->with('success', 'Data berhasil dihapus');
    }


    public function searchPeminjaman(Request $request)
    {
        
        $search = $request->input('search');
        $keranjang = session()->get('keranjang', []);

        $peminjamanResults = Barang::whereIn('id', array_keys($keranjang))
            ->where('nama', 'like', "%{$search}%")
            ->get();

        return view('peminjaman.searchpeminjaman', compact('peminjamanResults', 'keranjang'))->render();
    }



    public function searchRiwayat(Request $request)
    {
        $query = $request->input('search');
            $section = $request->input('section');

            if ($section == 'sedang-proses-section') {
                $peminjamans = Peminjaman::whereNull('tanggal_kembali')
                    ->where('keperluan', 'like', "%$query%")
                    ->with('keranjang.barang')
                    ->get();
            } else {
                $peminjamans = Peminjaman::whereNotNull('tanggal_kembali')
                    ->where('keperluan', 'like', "%$query%")
                    ->with('keranjang.barang')
                    ->get();
            }

            return view('riwayat.searchriwayat', compact('peminjamans'))->render();

    }

    public function autocomplete(Request $request)
    {
        $keyword = $request->query('query');
        $barang = Barang::where('nama', 'LIKE', "%{$keyword}%")
                        ->select('id', 'nama')
                        ->get();
        return response()->json($barang);
    }


}