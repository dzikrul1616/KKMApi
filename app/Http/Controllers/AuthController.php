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
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required',
            'otp_number' => 'required',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $user = User::where('phone_number', $request->phone_number)
            ->where('otp_number', $request->otp_number)
            ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor telepon atau OTP salah',
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
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

        $otp = mt_rand(100000, 999999);

        // $twilio = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
        // $message = $twilio->messages->create(
        //     $request->phone_number,
        //     array(
        //         'from' => env('TWILIO_FROM_NUMBER'),
        //         'body' => 'Kode OTP Anda adalah ' . $otp
        //     )
        // );

        $user->update([
            'otp_number' => $otp,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'OTP berhasil dikirim',
            'otp' => $otp,
        ]);
    }

    public function verifyOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required',
            'otp_number' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor telepon dan OTP tidak boleh kosong',
            ], 400);
        }

        $user = User::where('phone_number', $request->phone_number)
            ->where('otp_number', $request->otp_code)
            ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'OTP salah',
            ], 401);
        }

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }
}
