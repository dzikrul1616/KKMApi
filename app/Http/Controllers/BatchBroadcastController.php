<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RumahSakit;
use App\Models\Branch;
use App\Models\BatchBroadcast;
use app\Models\User;

class BatchBroadcastController extends Controller
{
    public function addBroadcast(Request $request)
    {
        $tasker_id = $request->input('tasker_id');
        $batch_id = $request->input('batch_id');
        $hospital_id = $request->input('hospital_id');
        $status_batch = $request->input('status_batch');

        $batchBroadcast = new BatchBroadcast();
        $batchBroadcast->tasker_id = $tasker_id;
        $batchBroadcast->batch_id = $batch_id;
        $batchBroadcast->hospital_id = $hospital_id;
        $batchBroadcast->status_batch = $status_batch;
        $batchBroadcast->save();
    
        if (!$batchBroadcast->save()) {
            $result = [
                'success' => false,
                'message' => 'Failed to save data Batch Broadcast'
            ];
            return response()->json($result, 500);
        }

        $result = [
            'success' => true,
            'data' => $batchBroadcast,
            'message' => 'Data Batch Broadcast saved successfully'
        ];

        return response()->json($result, 200);
        }
    public function getBroadcast()
    {
        $broadcasts = BatchBroadcast::with('hospital')
                        ->with('user')
                        ->with('batch')
                        ->get();
        $result = [
            'success' => true,
            'data' => $broadcasts,
            'message' => 'Data Batch Broadcast retrieved successfully'
        ];

        return response()->json($result, 200);
    }

}
