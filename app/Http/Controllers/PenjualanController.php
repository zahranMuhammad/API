<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    /**
     * @OA\Post(
     *     path="/transaksi",
     *     tags={"Transaksi"},
     *     summary="Buat transaksi penjualan baru",
     *     description="Membuat transaksi penjualan dengan beberapa produk sekaligus",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="produks",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="produk_id", type="integer", example=1),
     *                     @OA\Property(property="qty", type="integer", example=2)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transaksi berhasil dibuat",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Berhasil"),
     *             @OA\Property(property="penjualan_id", type="integer", example=10),
     *             @OA\Property(
     *                 property="detail",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="produk_id", type="integer", example=1),
     *                     @OA\Property(property="qty", type="integer", example=2),
     *                     @OA\Property(property="total", type="number", format="float", example=40000)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validasi gagal"
     *     )
     * )
     */

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
