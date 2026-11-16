<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserApiController extends Controller
{
    /**
     * Menampilkan seluruh data (Get All)
     */
    public function index()
    {
        $data = User::all();

        return response()->json([
            'message' => 'Berhasil mengambil semua data',
            'data' => $data
        ], 200);
    }

    /**
     * Menampilkan data spesifik berdasarkan ID (Get By ID)
     */
    public function show($id)
    {
        $data = User::find($id);

        // Validasi jika data tidak ditemukan (Status 404)
        if (!$data) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'message' => 'Detail data ditemukan',
            'data' => $data
        ], 200);
    }

    /**
     * Registrasi user baru (POST) + validasi token
     */
  public function store(Request $request)
{
    if ($request->bearerToken() !== 'TOKEN-RAHASIA-123') {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = User::create([
        'nama' => $request->nama,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    return response()->json([
        'message' => 'Register berhasil',
        'data' => $user,
    ], 201);
    }
}