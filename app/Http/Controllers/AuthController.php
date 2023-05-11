<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Hash;
use Validator;
use App\Models\Pesakit;
use App\Models\PesakitObat;
use App\Models\Obat;
use App\Models\Branch;
use DB;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function index()
    {
        $user = User::with([
            'branch',
            'pesakit'
        ])->get();
        $result = [
            'success' => true,
            'data' => $user,
            'message' => 'Data User'
        ];
        return response()->json($result, 200);
    }
    public function auth(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $credentials = [
            'email' => $email,
            'password' => $password,
        ];

        if (Auth::attempt($credentials)) {
            // Jika autentikasi berhasil, kirim respon dengan status 200 OK
             $user = Auth::user();
             $token = $user->createToken('token')->plainTextToken;
             return response()->json([
                'status' => 'success',
                'message' => 'Login berhasil',
                'user' => $user,
                'token' => $token
            ], 200);
          } else {
              // Jika autentikasi gagal, coba lagi dengan mengubah password menjadi terbcrypt
              $user = User::where('email', $email)->first();
              if ($user && \Hash::check($password, $user->password)) {
                  Auth::login($user);
                  return response()->json([
                   'status' => 'success',
                   'message' => 'Login berhasil',
                   'user' => $user,
                   'token' => $token
                  ], 200);
              } else {
                  // Jika autentikasi gagal lagi, kirim respon dengan status 401 Unauthorized
                  return response()->json([
                      'message' => 'email atau password salah'
                  ], 401);
            }
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5',
            'specialist' => 'required|string',
            'hospital' => 'required|string',
        ], [
            'name.required' => 'Form nama lengkap wajib diisi !',
            'email.unique' => 'Email telah terdaftar, gunakan email lainnya',
            'email.required' => 'Form email wajib diisi !',
            'email.email' => 'Format email salah',
            'password.min' => 'Password minimal 5 karakter',
            'password.required' => 'Form Password wajib diisi !',
            'specialist.required' => 'Form Specialist hp wajib diisi !',
            'hospital.required' => 'Form hospital hp wajib diisi !',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }
    
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->specialist = $request->specialist;
        $user->hospital = $request->hospital;
        $user->password = bcrypt($request->password);
        $user->save();
    
        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'Pendaftaran berhasil'
        ], 201);
    }
}
