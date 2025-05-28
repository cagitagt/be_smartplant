<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DeviceController;
use App\Http\Controllers\API\IrrigationScheduleController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\PlantController;
use App\Http\Controllers\API\SensorDataController;
use App\Http\Controllers\API\WateringHistoryController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::prefix('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('profile', [AuthController::class, 'profile']);
    });

    // Plant routes
    Route::apiResource('plants', PlantController::class);

    // Nested routes for plant-related resources
    Route::prefix('plants/{plant}')->group(function () {
        Route::get('sensor-data', [SensorDataController::class, 'index']);
        Route::post('sensor-data', [SensorDataController::class, 'store']);
        Route::get('sensor-data/latest', [SensorDataController::class, 'latest']);

        Route::apiResource('irrigation-schedules', IrrigationScheduleController::class);
        Route::apiResource('devices', DeviceController::class);
        Route::apiResource('watering-history', WateringHistoryController::class);
        Route::apiResource('notifications', NotificationController::class);
    });
});
