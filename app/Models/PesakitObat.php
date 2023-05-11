<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesakitObat extends Model
{
    use HasFactory;
    protected $fillable = [
        'pesakit_id',
        'obat_id'
    ];
}
