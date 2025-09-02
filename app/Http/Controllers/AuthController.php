<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/register",
     *     tags={"Auth"},
     *     summary="Register user baru",
     *     description="Mendaftarkan user baru ke dalam sistem.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nama","email","alamat","password","password_confirmation"},
     *             @OA\Property(property="nama", type="string", example="Jamaludin Raka"),
     *             @OA\Property(property="email", type="string", format="email", example="jamal@example.com"),
     *             @OA\Property(property="alamat", type="string", example="Jl. Merdeka No. 123"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Berhasil Register",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Berhasil Register Sekarang Silakan Login")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation Error"
     *     )
     * )
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:2|max:255',
            'email' => 'required|email|unique:users,email',
            'alamat' => 'required|min:3|max:255',
            'password' => 'required|confirmed|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 400);
        }

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'Berhasil Register Sekarang Silakan Login',
        ], 201);
    }

    /**
     * @OA\Post(
     *     path="/login",
     *     tags={"Auth"},
     *     summary="Login user",
     *     description="Login user menggunakan email dan password untuk mendapatkan token.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="jamal@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login Berhasil",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="1|qwertyuiop123456"),
     *             @OA\Property(property="message", type="string", example="Berhasil Login")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $token = $user->createToken('lks_api')->plainTextToken;

        return response()->json([
            'token' => $token,
            'message' => 'Berhasil Login'
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/logout",
     *     tags={"Auth"},
     *     summary="Logout user",
     *     description="Logout user dengan menghapus semua token aktif.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logout Berhasil",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Berhasil Logout")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function logout()
    {
        Auth::user()->tokens()->delete();

        return response()->json([
            'message' => 'Berhasil Logout'
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/profile",
     *     tags={"Auth"},
     *     summary="Profil user login",
     *     description="Mengambil data profil user yang sedang login.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Data Profil",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="nama", type="string", example="Zahran Muhammad"),
     *             @OA\Property(property="email", type="string", example="zahran@example.com"),
     *             @OA\Property(property="alamat", type="string", example="Jl. Merdeka No. 123"),
     *         )
     *     )
     * )
     */
    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    public function login_dulu()
    {
        return response()->json([
            'message' => 'Login Dulu'
        ], 400);
    }
}
