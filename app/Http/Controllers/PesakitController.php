<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesakit;
use App\Models\Branch;

class PesakitController extends Controller
{
    public function index()
    {
        $pesakit = Pesakit::all();
        $result = [
            'success' => true,
            'data' => $pesakit,
            'message' => 'Data Pesakit'
        ];
        return response()->json($result, 200);
    }
}
