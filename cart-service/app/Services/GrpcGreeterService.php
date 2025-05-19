<?php

namespace App\Services;


use App\Grpc\Generated\GreeterClient;
use App\Grpc\Generated\HelloRequest;
use Grpc\ChannelCredentials;

class GrpcGreeterService
{
    public function sayHelloToProduct(): string
    {
        $client = new \App\Grpc\Generated\GreeterClient(
            '127.0.0.1:50051',
            ['credentials' => \Grpc\ChannelCredentials::createInsecure()]
        );


        $request = new HelloRequest();
        $request->setName('Ahmed');

        [$response, $status] = $client->SayHello($request)->wait();

        if ($status->code !== \Grpc\STATUS_OK) {
            throw new \Exception("gRPC Error: {$status->details}");
        }

        return $response->getMessage();
    }
}
