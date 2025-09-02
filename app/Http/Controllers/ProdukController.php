<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    /**
     * @OA\Get(
     *     path="/produk",
     *     summary="Ambil semua produk",
     *     tags={"Produk"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="filter[nama]",
     *         in="query",
     *         description="Filter produk berdasarkan nama",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="filter[harga]",
     *         in="query",
     *         description="Filter produk berdasarkan harga",
     *         required=false,
     *         @OA\Schema(type="number")
     *     ),
     *     @OA\Parameter(
     *         name="filter[rating]",
     *         in="query",
     *         description="Filter produk berdasarkan rating",
     *         required=false,
     *         @OA\Schema(type="number")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil ambil daftar produk",
     *         @OA\JsonContent(
     *             @OA\Property(property="produk", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="nama", type="string", example="Sepatu Running"),
     *                     @OA\Property(property="harga", type="number", example=250000),
     *                     @OA\Property(property="rating", type="number", example=4.5),
     *                     @OA\Property(property="gambar_produk", type="string", example="sepatu.png")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/produk",
     *     summary="Tambah produk baru",
     *     tags={"Produk"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nama","harga","rating","gambar_produk"},
     *             @OA\Property(property="nama", type="string", example="Sepatu Futsal"),
     *             @OA\Property(property="harga", type="number", example=150000),
     *             @OA\Property(property="rating", type="number", example=4.2),
     *             @OA\Property(property="gambar_produk", type="string", example="futsal.jpg")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Produk berhasil ditambahkan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Produk berhasil ditambahkan"),
     *             @OA\Property(property="produk", type="object",
     *                 @OA\Property(property="id", type="integer", example=2),
     *                 @OA\Property(property="nama", type="string", example="Sepatu Futsal"),
     *                 @OA\Property(property="harga", type="number", example=150000),
     *                 @OA\Property(property="rating", type="number", example=4.2),
     *                 @OA\Property(property="gambar_produk", type="string", example="futsal.jpg")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validasi gagal / produk sudah ada"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:3|max:255',
            'harga' => 'required|numeric',
            'rating' => 'required|min:2',
            'gambar_produk' => 'required|min:3'
        ]);

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
