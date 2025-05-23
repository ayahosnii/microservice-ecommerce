<?php

namespace App\Services;

use App\Grpc\Generated\GreeterClient;
use App\Grpc\Generated\HelloRequest;
use Grpc\ChannelCredentials;
use const Grpc\STATUS_OK;

class GrpcGreeterService
{
    protected GreeterClient $client;

    public function __construct()
    {
        $this->client = new GreeterClient('127.0.0.1:50051', [
            'credentials' => ChannelCredentials::createInsecure(),
        ]);
    }

    public function sayHello(string $name, string $email): string
    {
        $request = new HelloRequest();
        $request->setName($name);
        $request->setEmail($email);

        [$response, $status] = $this->client->SayHello($request)->wait();

        if ($status->code !== STATUS_OK) {
            throw new \RuntimeException("gRPC Error: {$status->details}");
        }

        return $response->getMessage();
    }
}
