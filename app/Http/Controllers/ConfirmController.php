<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Confirm;

class ConfirmController extends Controller
{
    public function index()
    {
        $confirm = Confirm::all();
        $result = [
            'success' => true,
            'data' => $confirm,
            'message' => 'Data confirm'
        ];
        return response()->json($result, 200);
    }
}
