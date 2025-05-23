<?php

use App\Grpc\Generated\GreeterClient;
use App\Grpc\Generated\HelloRequest;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/grpc-test', function () {
    // Connect to Node.js gRPC server
    $client = new GreeterClient('127.0.0.1:50051', [
        'credentials' => \Grpc\ChannelCredentials::createInsecure(),
    ]);

    // Create and send the request
    $request = new HelloRequest();
    $request->setName('Ahmed');

    // Receive the response
    [$response, $status] = $client->SayHello($request)->wait();

    if ($status->code !== \Grpc\STATUS_OK) {
        return response("gRPC Error: {$status->details}", 500);
    }

    // ✅ Return the message from Node.js
    return $response->getMessage();  // ← This is the actual message from product-service
});
