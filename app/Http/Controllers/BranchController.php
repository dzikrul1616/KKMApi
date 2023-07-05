<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Pesakit;
use app\Models\User;
use DB;
use Auth;

class BranchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
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
    public function getBranchId(Request $request)
    {
        $user = Auth::user();
        $branches = Branch::where('user_id', $user->id)
                        ->join('users', 'users.id', '=', 'branches.user_id')
                        ->select('branches.*', 'users.name', 'users.hospital', 'users.specialist', 'users.profil', 'users.gender')
                        ->with('pesakit')
                        ->get();
        $filter = $request->input('filter');
        $result = [
            'success' => true,
            'data' => $branches,
            'message' => 'Success Mengambil Data'
        ];
        return response()->json($result, 200);
    }
    public function getBranchIdPesakit($user_id)
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
    public function addBranch(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'tanggal' => 'required',
            'jam' => 'required',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'tanggal.required' => 'Tanggal wajib diisi',
            'jam.required' => 'Jam wajib diisi',
        ]);
        $user = Auth::user();
        $branch = Branch::create([
            'nama' => $validatedData['nama'],
            'tanggal' => $validatedData['tanggal'],
            'jam' => $validatedData['jam'],
            'user_id' => $user->id,
        ]);

        $result = [
            'success' => true,
            'data' => $branch,
            'message' => 'Data branch berhasil ditambahkan'
        ];

        return response()->json($result, 200);
    }
    public function deleteBranch(Request $request, $id)
    {
        $user = Auth::user();
        $branch = Branch::where('user_id', $user->id)
                    ->where('id', $id)
                    ->first();
        if (!$branch) {
            $result = [
                'success' => false,
                'message' => 'Branch not found'
            ];
            return response()->json($result, 404);
        }
        try {
            $branch->delete();
            $result = [
                'success' => true,
                'message' => 'Branch deleted successfully'
            ];
            return response()->json($result, 200);
        } catch (\Exception $e) {
            $result = [
                'success' => false,
                'message' => 'Failed to delete branch'
            ];
            return response()->json($result, 500);
        }
    }
}
