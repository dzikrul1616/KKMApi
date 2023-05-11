<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PesakitObat;

class PesakitObatController extends Controller
{
    public function index(){
        return response()->json([
            'status' => 'success',
            'message' => 'Data Pesakit Obat',
            'data' => PesakitObat::all()
        ], 200);
    }
}
