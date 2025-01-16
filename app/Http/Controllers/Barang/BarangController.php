<?php

namespace App\Http\Controllers\Barang;
use App\Models\Barang;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $max_data = 10;
        $data = Barang::paginate($max_data);  
        return view('barang.index', compact('data'));
    }

    public function search(Request $request)
    {
        $max_data = 10;

        $data = Barang::where('nama', 'like', '%'. $request->search . '%')->orWhere('jenis', 'like', '%' . $request->search . '%')->paginate($max_data);

        return view('barang.searchbarang', compact('data'))->render();
    }

    public function store(Request $request){
    $request->validate([
        'nama' => 'required|string|max:255',
        'jenis' => 'required|string|max:255', 
        'stok' => 'required|numeric|min:0',
    ], [
        'stok.min' => 'Stok barang tidak bisa kurang dari 0',
    ]);

    Barang::create([
        'nama' => $request->nama,
        'jenis' => $request->jenis,
        'stok' => $request->stok,
    ]);

    return redirect()->back()->with('success', 'Barang berhasil ditambahkan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    $request->validate([
        'nama' => 'required|string|max:255',
        'jenis' => 'required|string|max:255',
        'stok' => 'required|numeric|min:0',
    ], [
        'stok.min' => 'Stok barang tidak bisa kurang dari 0',
    ]);

    $barang = Barang::find($id);

    if (!$barang) {
        return response()->json([
            'success' => false,
            'message' => 'Barang tidak ditemukan.'
        ]);
    }

    if ($barang->stok < 0) {
        return response()->json([
            'success' => false,
            'message' => 'Stok barang tidak tersedia.'
        ]);
    }

    $barang->nama = $request->input('nama');
    $barang->jenis = $request->input('jenis');
    $barang->stok = $request->input('stok');
    
    $barang->save();

    return redirect()->back()->with('success', 'Data barang berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barang = Barang::findOrFail($id);

        $barang->delete();

        return redirect()->route('barang')->with('success', 'Barang berhasil dihapus.');
    
    }


    
}
