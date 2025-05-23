<?php

use App\Http\Controllers\GrpcTestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/grpc-test', [GrpcTestController::class, 'index']);
