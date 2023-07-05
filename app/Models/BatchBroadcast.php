<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchBroadcast extends Model
{
    use HasFactory;
    protected $fillable = [
        'tasker_id',
        'batch_id', 
        'hospital_id', 
        'status_batch'
    ];
    public function batch()
    {
        return $this->belongsTo(Branch::class, 'id', 'batch_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'tasker_id');
    }
    public function hospital()
    {
        return $this->belongsTo(RumahSakit::class, 'id', 'hospital_id');
    }
}
