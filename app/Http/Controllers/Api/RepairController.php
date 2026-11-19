<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Repair;
use Illuminate\Http\JsonResponse;

class RepairController extends Controller
{
    public function index(): JsonResponse
    {
        $repairs = Repair::query()
            ->orderBy('starts_at')
            ->get([
                'id',
                'mechanic_id',
                'starts_at',
                'ends_at',
                'status',
            ]);

        return response()->json([
            'data' => $repairs,
        ]);
    }

    public function show(Repair $repair): JsonResponse
    {
        return response()->json([
            'data' => [
                'id' => $repair->id,
                'mechanic_id' => $repair->mechanic_id,
                'starts_at' => $repair->starts_at,
                'ends_at' => $repair->ends_at,
                'status' => $repair->status,
            ],
        ]);
    }
}