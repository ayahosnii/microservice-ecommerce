<?php

namespace App\Http\Controllers;

use App\Services\GrpcGreeterService;
use Illuminate\Http\Request;

class GrpcTestController extends Controller
{
    public function greet()
    {
        $service = new GrpcGreeterService();
        $message = $service->sayHello('Ahmed');

        return response()->json(['message' => $message]);
    }
}
