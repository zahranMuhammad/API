<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'produks' => 'required|array',
            'produks.*.produk_id' => 'required|numeric|exists:produks,id',
            'produks.*.qty' => 'required|numeric|min:1',
        ]);

        $penjualan= Penjualan::create();

        $penjualan_id = $penjualan->id;

        $detail_penjualan = [];

        foreach($request->produks as $produk) {

            $harga = Produk::find($produk['produk_id'])->harga;
            $qty = $produk['qty'];
            $total_bayar = $harga * $qty;

            $detail_penjualan[] = [
                'penjualan_id' => $penjualan_id,
                'produk_id' => $produk['produk_id'],
                'qty' => $qty,
                'total' => $total_bayar,
            ];
        }

        DetailPenjualan::insert($detail_penjualan);

        $detailResponse = array_map(function($item) {
            return [
                'produk_id' => $item['produk_id'],
                'qty' => $item['qty'],
                'total' => $item['total'],
            ];
        }, $detail_penjualan);

        return response()->json([
            'message' => 'Berhasil',
            'penjualan_id' => $penjualan_id,
            'detail' => $detailResponse
        ], 200);
    }
}
