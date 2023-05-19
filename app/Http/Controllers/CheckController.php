<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Validator;


class CheckController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    public function checkAuthStatus()
    {
        $user = Auth::user();
        $user = User::where('id', $user->id)->get();
        return response()->json([
            'success' => true,
            'message' => 'User telah diautentikasi',
            'user' => $user,
        ],200);
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }
    public function registerData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'profil' => 'required',
            'gender' => 'required',
            'specialist' => 'required|string',
            'hospital' => 'required|string',
        ], [
            'name.required' => 'Form nama lengkap wajib diisi!',
            'profil.required' => 'Profil wajib diisi!',
            'gender.required' => 'Gender wajib diisi!',
            'specialist.required' => 'Form Specialist hp wajib diisi!',
            'hospital.required' => 'Form hospital hp wajib diisi!',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();
        $user->name = $request->name;
        if ($request->hasFile('profil')) {
            $file = $request->file('profil');
            $path = $file->store('public/');
            $user->profil = basename($path);
            $url = url('storage/' . $path);
        }
        $user->gender = $request->gender;
        $user->specialist = $request->specialist;
        $user->hospital = $request->hospital;
        $user->save();

        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'Pembaruan berhasil'
        ], 200);
    }

}
