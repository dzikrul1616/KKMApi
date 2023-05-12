<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Pesakit;
use DB;

class BranchController extends Controller
{
    public function index()
    {
        $branch = Branch::join('users', 'users.id', '=', 'branches.user_id')
                    ->select('branches.*', 'users.name', 'users.hospital', 'users.specialist')
                    ->with('pesakit')
                    ->get();
        $result = [        
            'success' => true,        
            'data' => $branch,        
            'message' => 'Success Mengambil Data'    
        ];
        return response()->json($result, 200);
    }
    public function getBranchId($user_id)
    {
        $branches = Branch::where('user_id', $user_id)
                        ->join('users', 'users.id', '=', 'branches.user_id')
                        ->select('branches.*', 'users.name', 'users.hospital', 'users.specialist')
                        ->with('pesakit')
                        ->get();
        $result = [
            'success' => true,
            'data' => $branches,
            'message' => 'Success Mengambil Data'
        ];
        return response()->json($result, 200);
    }
    // public function getBranchIdPesakit($user_id)
    // {
    //     $branches = Branch::where('user_id', $user_id)
    //                     ->join('users', 'users.id', '=', 'branches.user_id')
    //                     ->select('branches.*', 'users.name', 'users.hospital', 'users.specialist')
    //                     ->with('pesakit')
    //                     ->get();
    //     $result = [
    //         'success' => true,
    //         'data' => $branches,
    //         'message' => 'Success Mengambil Data'
    //     ];
    //     return response()->json($result, 200);
    // }
    public function addBranch(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'tanggal' => 'required',
            'jam' => 'required',
            'user_id' => 'required',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'tanggal.required' => 'Tanggal wajib diisi',
            'jam.required' => 'Jam wajib diisi',
            'user_id.required' => 'User ID wajib diisi',
        ]);

        $branch = Branch::create([
            'nama' => $validatedData['nama'],
            'tanggal' => $validatedData['tanggal'],
            'jam' => $validatedData['jam'],
            'user_id' => $validatedData['user_id'],
        ]);

        $result = [
            'success' => true,
            'data' => $branch,
            'message' => 'Data branch berhasil ditambahkan'
        ];

        return response()->json($result, 200);
    }

}
