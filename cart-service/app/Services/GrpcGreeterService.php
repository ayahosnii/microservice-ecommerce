<?php

namespace App\Services;


use App\Grpc\Generated\App\GreeterClient;
use App\Grpc\Generated\App\HelloRequest;
use Grpc\ChannelCredentials;

class GrpcGreeterService
{
    public function sayHello(string $name): string
    {
        $client = new GreeterClient('localhost:50051', [
            'credentials' => ChannelCredentials::createInsecure()
        ]);

        $request = new HelloRequest();
        $request->setName($name);

        [$response, $status] = $client->SayHello($request)->wait();

        if ($status->code !== \Grpc\STATUS_OK) {
            throw new \Exception("gRPC error: {$status->details}");
        }

        return $response->getMessage();
    }
}
