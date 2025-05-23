// Path to the protobuf (.proto) file describing the gRPC service and messages
var PROTO_PATH = __dirname + '/../protos/helloworld.proto';

// Import gRPC core library for Node.js
var grpc = require('@grpc/grpc-js');

// Import protobuf loader to load .proto files dynamically
var protoLoader = require('@grpc/proto-loader');

// Load the protobuf definitions from the .proto file with options:
// - keepCase: keep field names as-is (instead of converting to camelCase)
// - longs, enums: represent as strings
// - defaults: include default values for fields
// - oneofs: include support for oneof fields
var packageDefinition = protoLoader.loadSync(
    PROTO_PATH,
    {
        keepCase: true,
        longs: String,
        enums: String,
        defaults: true,
        oneofs: true
    }
);

// Load the package definition into a gRPC object
// 'helloworld' is the package name declared in the proto file
var hello_proto = grpc.loadPackageDefinition(packageDefinition).helloworld;

/**
 * Implements the SayHello RPC method defined in the proto.
 * @param {Object} call - Contains the request info (call.request has parameters)
 * @param {Function} callback - Function to send response back to client
 */
function sayHello(call, callback) {
    // Construct and send response message with greeting using request name
    callback(null, {message: 'Hello ' + call.request.name + ' :D Your email ' +  call.request.email});
}

/**
 * Main function to start the gRPC server.
 */
function main() {
    // Create a new gRPC server instance
    var server = new grpc.Server();

    // Register the Greeter service and bind the sayHello function as handler
    server.addService(hello_proto.Greeter.service, {sayHello: sayHello});

    // Bind server to all network interfaces on port 50051, with insecure credentials
    server.bindAsync('0.0.0.0:50051', grpc.ServerCredentials.createInsecure(), () => {
        // Start the server after binding completes
        server.start();
    });
}

// Invoke main function to launch the server
main();
