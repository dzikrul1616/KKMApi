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
    public function getPesakitId($branch_id)
    {
        $pesakit = Pesakit::where('branch_id', $branch_id)
                          ->get();
        $result = [
            'success' => true,
            'data' => $pesakit,
            'message' => 'Data Pesakit'
        ];
        return response()->json($result, 200);
    }
    public function addPesakit(Request $request)
    {
        $validatedData = $request->validate([
            'branch_id' => 'required',
            'nama' => 'required',
            'tanggal_lahir' => 'required',
            'diagnosis' => 'required',
            'jenis_kelamin' => 'required',
            'height' => 'required',
            'weight' => 'required',
            'age' => 'required',
            'negeri' => 'required',
            'kode_pos' => 'required',
            'house_number' => 'required',
            'phone_number' => 'required'
        ], [
            'branch_id.required' => 'Branch id harus diisi',
            'nama.required' => 'Nama harus diisi',
            'tanggal_lahir.required' => 'Tanggal lahir harus diisi',
            'diagnosis.required' => 'Diagnosis harus diisi',
            'jenis_kelamin.required' => 'Jenis kelamin harus diisi',
            'height.required' => 'Tinggi badan harus diisi',
            'weight.required' => 'Berat badan harus diisi',
            'age.required' => 'Umur harus diisi',
            'negeri.required' => 'Negeri harus diisi',
            'kode_pos.required' => 'Kode pos harus diisi',
            'house_number.required' => 'Nomor rumah harus diisi',
            'phone_number.required' => 'Nomor telepon harus diisi'
        ]);

        $pesakit = Pesakit::create([
            'branch_id' => $validatedData['branch_id'],
            'nama' => $validatedData['nama'],
            'tanggal_lahir' => $validatedData['tanggal_lahir'],
            'diagnosis' => $validatedData['diagnosis'],
            'jenis_kelamin' => $validatedData['jenis_kelamin'],
            'height' => $validatedData['height'],
            'weight' => $validatedData['weight'],
            'age' => $validatedData['age'],
            'negeri' => $validatedData['negeri'],
            'kode_pos' => $validatedData['kode_pos'],
            'house_number' => $validatedData['house_number'],
            'phone_number' => $validatedData['phone_number']
        ]);

        $result = [
            'success' => true,
            'data' => $pesakit,
            'message' => 'Data pesakit berhasil ditambahkan'
        ];

        return response()->json($result, 200);
    }
    public function deletePesakit($pesakit_id)
    {
        $pesakit = Pesakit::find($pesakit_id);
        if (!$pesakit) {
            $result = [
                'success' => false,
                'message' => 'Pesakit not found'
            ];
            return response()->json($result, 404);
        }
        try {
            $pesakit->delete();
            $result = [
                'success' => true,
                'message' => 'Pesakit deleted successfully'
            ];
            return response()->json($result, 200);
        } catch (\Exception $e) {
            $result = [
                'success' => false,
                'message' => 'Failed to delete pesakit'
            ];
            return response()->json($result, 500);
        }
    }
}
