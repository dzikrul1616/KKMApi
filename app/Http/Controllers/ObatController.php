<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Obat;

class ObatController extends Controller
{
    public function index()
    {
        $obat = Obat::all();
        $result = [
            'success' => true,
            'data' => $obat,
            'message' => 'Data Obat'
        ];
        return response()->json($result, 200);
    }
    public function addObat(Request $request)
    {
        $validateData = $request->validate([
            'nama_obat' => 'required',
            'image' => 'required',
            'type' => 'required',
            'lenght' => 'required',
            'golongan' => 'required',
            'dosis' => 'required',
            'efek_samping' => 'required',
            'kategori_obat' => 'required',
            'harga_obat' => 'required',
            'konsum_obat' => 'required',
            'stock' => 'required'
        ],[
            'nama_obat.required' => 'Nama Obat Wajib Diisi',
            'image.required' => 'Image Wajib Diisi',
            'type.required' => 'Type Wajib Diisi',
            'lenght.required' => 'Lenght Wajib Diisi',
            'golongan.required' => 'golongan Wajib Diisi',
            'dosis.required' => 'dosis Wajib Diisi',
            'efek_samping.required' => 'efek_samping Wajib Diisi',
            'kategori_obat.required' => 'kategori Obat Wajib Diisi',
            'harga_obat.required' => 'Harga Obat Wajib Diisi',
            'konsum_obat.required' => 'Konsum Obat Wajib Diisi',
            'stock.required' => 'Stock Wajib Diisi'
        ]);

        $obat = new Obat();
        $obat->nama_obat = $validateData['nama_obat'];
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('public/');
            $obat->image = basename($path);
            $url = url('storage/' . $path);
        }
        $obat->type = $validateData['type'];
        $obat->lenght = $validateData['lenght'];
        $obat->golongan = $validateData['golongan'];
        $obat->dosis = $validateData['dosis'];
        $obat->efek_samping = $validateData['efek_samping'];
        $obat->kategori_obat = $validateData['kategori_obat'];
        $obat->harga_obat = $validateData['harga_obat'];
        $obat->konsum_obat = $validateData['konsum_obat'];
        $obat->stock = $validateData['stock'];
        $obat->save();
        $result = [
            'success' => true,
            'data' => $obat,
            'message' => 'Data Obat Berhasil Ditambahkan'
        ];
        return response()->json($result, 200);
    }   
}
