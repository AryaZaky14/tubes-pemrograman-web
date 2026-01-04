<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'jumlah' => 'required|numeric'
        ]);

        Barang::create($request->all());

        return redirect()->route('barang.index')
            ->with('success', 'Berhasil menambahkan data');
    }

    // =========================
    //  EDIT BARANG
    // =========================
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.edit', compact('barang'));
    }

    // =========================
    //  UPDATE BARANG
    // =========================
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'jumlah' => 'required|numeric'
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update($request->all());

        return redirect()->route('barang.index')
            ->with('success', 'Data berhasil diperbarui');
    }
    // =========================
    //  HAPUS BARANG
    // =========================
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang.index')
            ->with('success', 'Data berhasil dihapus');
    }

}
