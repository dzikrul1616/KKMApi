<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Pesakit extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'tanggal_lahir',
        'umur',
        'diagnosis', 
        'jenis_kelamin', 
        'height', 
        'weight', 
        'age', 
        'negeri', 
        'kode_pos', 
        'note', 
        'house_number', 
        'phone_number'
    ];
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function user()
    {
        return $this->hasMany(Branch::class, 'user_id', 'id');
    }
}
