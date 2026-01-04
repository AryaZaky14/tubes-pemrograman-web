<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    // ======================
    // HALAMAN KASIR
    // ======================
    public function index()
    {
        $barang = Barang::where('jumlah', '>', 0)->get();
        $cart = session()->get('cart', []);

        $sum = 0;
        foreach ($cart as $item) {
            $sum += $item['harga'] * $item['qty'];
        }

        return view('kasir.index', compact('barang', 'cart', 'sum'));
    }

    // ======================
    // TAMBAH KE KERANJANG
    // ======================
    public function tambah(Request $request)
    {
        $barang = Barang::where('nama', $request->nama_barang)->first();

        if (!$barang || $barang->jumlah <= 0) {
            return redirect()->back()->with('error', 'Stok habis');
        }

        if ($request->qty > $barang->jumlah) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$barang->id_barang])) {

            $totalQty = $cart[$barang->id_barang]['qty'] + $request->qty;

            if ($totalQty > $barang->jumlah) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi');
            }

            $cart[$barang->id_barang]['qty'] = $totalQty;
        } else {
            $cart[$barang->id_barang] = [
                'id' => $barang->id_barang,
                'nama' => $barang->nama,
                'harga' => $barang->harga,
                'qty' => $request->qty
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('kasir.index');
    }

    // ======================
    // UPDATE QTY
    // ======================
    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        $i = 0;

        foreach ($cart as $key => $item) {

            $barang = Barang::find($item['id']);

            if ($request->qty[$i] > $barang->jumlah) {
                return redirect()
                    ->route('kasir.index')
                    ->with('error', 'Stok barang ' . $barang->nama . ' tidak mencukupi');
            }

            $cart[$key]['qty'] = $request->qty[$i];
            $i++;
        }

        session()->put('cart', $cart);
        return redirect()->route('kasir.index');
    }

    // ======================
    // HAPUS ITEM
    // ======================
    public function hapus($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);

        return redirect()->route('kasir.index');
    }

    // ======================
    // PROSES TRANSAKSI
    // ======================
    public function transaksi(Request $request)
    {
        //  VALIDASI CART KOSONG
        $cart = session()->get('cart');

        if (!$cart || count($cart) == 0) {
            return redirect()
                ->route('kasir.index')
                ->with('error', 'Keranjang masih kosong');
        }

        //  VALIDASI BAYAR
        if ($request->bayar < $request->total) {
            return redirect()
                ->route('kasir.index')
                ->with('error', 'kurang');
        }

        $trx = null;

        try {

            DB::transaction(function () use ($request, $cart, &$trx) {

                $trx = Transaksi::create([
                    'nomor' => 'TRX-' . date('YmdHis'),
                    'nama' => Auth::user()->nama,
                    'total' => $request->total,
                    'bayar' => $request->bayar,
                    'kembali' => $request->bayar - $request->total,
                    'tanggal_waktu' => now()
                ]);

                foreach ($cart as $item) {

                    $barang = Barang::lockForUpdate()->find($item['id']);

                    if ($barang->jumlah < $item['qty']) {
                        throw new \Exception(
                            'Stok barang ' . $barang->nama . ' tidak mencukupi'
                        );
                    }

                    TransaksiDetail::create([
                        'id_transaksi' => $trx->id_transaksi,
                        'id_barang' => $item['id'],
                        'harga' => $item['harga'],
                        'qty' => $item['qty'],
                        'total' => $item['harga'] * $item['qty']
                    ]);

                    $barang->decrement('jumlah', $item['qty']);
                }
            });

        } catch (\Exception $e) {

            return redirect()
                ->route('kasir.index')
                ->with('error', $e->getMessage());
        }

        session()->forget('cart');

        return redirect()->route('kasir.struk', $trx->id_transaksi);
    }

    // ======================
    // STRUK
    // ======================
    public function struk($id)
    {
        $trx = Transaksi::findOrFail($id);

        $detail = TransaksiDetail::join(
            'barang',
            'transaksi_detail.id_barang',
            '=',
            'barang.id_barang'
        )
            ->where('transaksi_detail.id_transaksi', $id)
            ->select(
                'barang.nama',
                'transaksi_detail.qty',
                'transaksi_detail.harga',
                'transaksi_detail.total'
            )
            ->get();

        return view('kasir.struk', compact('trx', 'detail'));
    }
}
