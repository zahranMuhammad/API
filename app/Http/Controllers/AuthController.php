<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validasi inputan
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:2|max:255',
            'email' => 'required|email|unique:users,email',
            'alamat' => 'required|min:3|max:255',
            'password' => 'required|confirmed|min:8'
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 400);
        }

        // Membuat user baru
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'password' => Hash::make($request->password)
        ]);

        // Mengembalikan respons sukses dengan pesan dan data user beserta token
        return response()->json([
            'message' => 'Berhasil Register Sekarang Silakan Login',  // Pesan sukses
        ], 201); // 201 adalah status untuk resource yang baru dibuat
    }

    public function login(Request $request)
    {
        // Validasi input untuk login
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Mencari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Unauthorized', // Pesan jika login gagal
            ], 401);  // Status 401 untuk Unauthorized
        }

        // Generate token jika login berhasil
        $token = $user->createToken('lks_api')->plainTextToken;

        return response()->json([
            'token' => $token,
            'message' => 'Berhasil Login'
        ], 200); // Status 200 untuk OK
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();

        return response()->json([
            'message' => 'Berhasil Logout'
        ], 200);
    }

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
