<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Syntax version for Protocol Buffers — use proto3 for modern features and support
namespace App\Grpc\Generated;

/**
 * Define a gRPC service called "Greeter"
 */
class GreeterClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param \App\Grpc\Generated\HelloRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SayHello(\App\Grpc\Generated\HelloRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/helloworld.Greeter/SayHello',
        $argument,
        ['\App\Grpc\Generated\HelloReply', 'decode'],
        $metadata, $options);
    }

}
