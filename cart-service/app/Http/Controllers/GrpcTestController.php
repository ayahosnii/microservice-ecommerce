<?php

namespace App\Http\Controllers;

use App\Services\GrpcGreeterService;
use Illuminate\Http\Request;

class GrpcTestController extends Controller
{
    public function index(GrpcGreeterService $grpc)
    {
        try {
            $message = $grpc->sayHello('Aya', 'aya@gmail.com');
            return response()->json(['message' => $message]);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
