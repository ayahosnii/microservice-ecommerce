const grpc = require('@grpc/grpc-js');
const protoLoader = require('@grpc/proto-loader');
const path = require('path');

// Load .proto definition
const packageDef = protoLoader.loadSync(path.join(__dirname, 'proto', 'Greeter.proto'), {
    keepCase: true,
    longs: String,
    enums: String,
    defaults: true,
    oneofs: true
});

const grpcObject = grpc.loadPackageDefinition(packageDef);
console.log('Loaded gRPC Object:', grpcObject); // Optional debug

// ✅ Corrected based on actual package
const greeter = grpcObject.app.Greeter;

const server = new grpc.Server();
server.addService(greeter.service, {
    SayHello: (call, callback) => {
        const name = call.request.name;
        callback(null, { message: `Hello ${name} from product-service` });
    }
});

server.bindAsync('0.0.0.0:50051', grpc.ServerCredentials.createInsecure(), () => {
    console.log('✅ gRPC server running on port 50051');
});

