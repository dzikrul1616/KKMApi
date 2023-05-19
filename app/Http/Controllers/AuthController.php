<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Hash;
use Validator;
use App\Models\Pesakit;
use App\Models\PesakitObat;
use App\Models\Obat;
use App\Models\Branch;
use DB;
use Carbon\Carbon;
use Twilio\Rest\Client;
use Illuminate\Validation\ValidationException;

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
         $phone = $request->input('phone_number');
         $password = $request->input('password');

         $credentials = [
             'phone_number' => $phone,
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
                   // Jika autentikasi gagal lagi, kirim respon dengan status 401 Unauthorized
                return response()->json([
                    'message' => 'Phone atau password salah'
            ], 401);
         }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required',
        ], [
            'phone_number.required' => 'Form nomor telepon wajib diisi !'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }
        $user = new User();
        $user->phone_number = $request->phone_number;
        $user->save();
    
        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'Pendaftaran berhasil'
        ], 201);
    }

    public function sendOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $user = User::where('phone_number', $request->phone_number)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor telepon tidak terdaftar',
            ], 404);
        }

        
        // $twilio = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
        // $message = $twilio->messages->create(
            //     $request->phone_number,
            //     array(
                //         'from' => env('TWILIO_FROM_NUMBER'),
                //         'body' => 'Kode OTP Anda adalah ' . $otp
                //     )
                // );
                
        $password = mt_rand(100000, 999999);
        $user->update([
            'password' => Hash::make($password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'OTP berhasil dikirim',
            'phone' => $request->phone_number,
            'otp' => $password,
        ]);
    }
}
