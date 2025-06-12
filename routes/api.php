<?php

use App\Http\Controllers\Api\TodoApiController;
use Illuminate\Support\Facades\Route;

Route::get('/chart', [TodoApiController::class, 'getChartData']);
Route::post('/todos/create', [TodoApiController::class, 'store']);
Route::get('/todos/export', [TodoApiController::class, 'export']);
