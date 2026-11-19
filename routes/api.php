<?php

use App\Http\Controllers\Api\RepairController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Credenciales incorrectas.',
        ], 401);
    }

    return response()->json([
        'token' => $user->createToken('postman')->plainTextToken,
    ]);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/repairs', [RepairController::class, 'index']);
    Route::get('/repairs/{repair}', [RepairController::class, 'show']);
});