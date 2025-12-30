<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\User;
use App\Models\Transaksi;

class AdminController extends Controller
{
    public function index()
    {
        // Total data
        $barang = Barang::count();
        $user   = User::count();

        // Barang stok menipis
        $stok_tipis = Barang::where('jumlah', '<', 5)->get();

        // Barang stok habis
        $stok_habis = Barang::where('jumlah', '=', 0)->get();

        // 5 transaksi terakhir
        $transaksi = Transaksi::latest('tanggal_waktu')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'barang',
            'user',
            'stok_tipis',
            'stok_habis',
            'transaksi'
        ));
        if ($request->jumlah < 0) {
    return back()->with('error', 'Stok tidak boleh minus');
}

    }
}
