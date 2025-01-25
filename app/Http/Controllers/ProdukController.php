<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $produk = Produk::orderBy('id', 'DESC');

        if($request->has("filter")) {

            if(isset($request->filter['nama'])) {
                $filterNama = $request->filter['nama'];
                $produk->where('nama', 'like', "%$filterNama%");
            }

            if(isset($request->filter['harga'])) {
                $filterHarga = $request->filter['harga'];
                $produk->where('harga', 'like', "%$filterHarga%");
            }

            if(isset($request->filter['rating'])) {
                $filterRating = $request->filter['rating'];
                $produk->where('rating', 'like', "%$filterRating%");
            }
        }

        $produk = $produk->get();

        return response()->json([
            'produk' => $produk
        ], 200);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:3|max:255',
            'harga' => 'required|numeric',
            'rating' => 'required|min:2',
            'gambar_produk' => 'required|min:3'
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 400);
        }

        $produk_sudah_ada = Produk::where('nama', $request->nama)->first();

        if($produk_sudah_ada) {
            return response()->json([
                'message' => 'Produk ini sudah ada',
            ], 400);
        }

        // Membuat user baru
        $produk = Produk::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'rating' => $request->rating,
            'gambar_produk' => $request->gambar_produk
        ]);
        return response()->json([
            'message' => 'Produk berhasil ditambahkan',
            'produk' => $produk
        ], 201);
    }
}
