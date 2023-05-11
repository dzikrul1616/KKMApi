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
}
