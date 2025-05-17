<?php
// GENERATED CODE -- DO NOT EDIT!

namespace App;

/**
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
     * @param \App\HelloRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SayHello(\App\HelloRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/app.Greeter/SayHello',
        $argument,
        ['\App\HelloReply', 'decode'],
        $metadata, $options);
    }

}
