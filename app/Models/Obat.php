<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_obat',
        'image',
        'type', 
        'lenght', 
        'golongan', 
        'efek_samping',
        'kategori_obat',
        'harga_obat',
        'konsum_obat',
        'stock'
    ];
}
