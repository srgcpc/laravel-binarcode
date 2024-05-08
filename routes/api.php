<?php

use App\Http\Controllers\SchedulerController;
use App\Http\Middleware\IsValidHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/reminders/schedule', [SchedulerController::class, 'handle'])->middleware(IsValidHeader::class);
