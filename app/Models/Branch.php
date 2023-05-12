<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Branch extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'nama',
        'tanggal',
        'jam',
    ];

    public function pesakit()
    {
        return $this->hasMany(Pesakit::class, 'branch_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(Users::class, 'id', 'branch_id');
    }
}
