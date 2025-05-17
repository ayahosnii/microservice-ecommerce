<?php

use App\Http\Controllers\GrpcTestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/grpc-test', function () {
    return app(\App\Services\GrpcGreeterService::class)->sayHello('Ahmed');
});
