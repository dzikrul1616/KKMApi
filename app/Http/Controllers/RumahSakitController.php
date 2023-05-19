<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RumahSakit;


class RumahSakitController extends Controller
{
    public function index()
    {
        $rumahSakit = RumahSakit::all();
        return response()->json($rumahSakit);
    }
}
