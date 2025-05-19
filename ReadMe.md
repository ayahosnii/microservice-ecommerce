
---

# Beauty Bay Microservices Architecture

This project demonstrates a **microservices architecture** using **Kubernetes**, with separate services for managing products, shopping carts, and orders in an e-commerce platform. The architecture includes services for MySQL, MongoDB, and Redis for database and caching functionality.

## Table of Contents

- [Overview](#overview)
- [Architecture](#architecture)
- [Microservices](#microservices)
- [Databases and Caching](#databases-and-caching)
- [Deployment](#deployment)
- [Environment Variables](#environment-variables)
- [Usage](#usage)
- [Persistent Storage](#persistent-storage)
- [Kubernetes Services](#kubernetes-services)
- [Load Balancing](#load-balancing)

## Overview

The **Beauty Bay** project consists of multiple microservices deployed in a Kubernetes cluster, with each service responsible for different functionalities:
- **Product-Service**: Manages product-related operations.
- **Cart-Service**: Handles user shopping cart interactions.
- **Order-Service**: Manages customer orders.

The microservices are built with **Laravel** and communicate with databases like **MySQL** and **MongoDB** while using **Redis** for caching.

## Architecture

### Components:
- **Microservices**:
    - **Product-Service**
    - **Cart-Service**
    - **Order-Service**

- **Databases**:
    - **MySQL**: Primary relational database for managing products and orders.
    - **MongoDB**: NoSQL database for handling other data types.

- **Caching**:
    - **Redis**: Used for caching and session management.

### Kubernetes Resources:
- **Deployments**: For managing and scaling microservices.
- **Services**: Using `ClusterIP` for internal communication and `LoadBalancer` for external access.
- **PersistentVolumeClaims**: Ensuring data persistence for MySQL and MongoDB.

## Microservices

### Product-Service
Handles the management of products in the catalog, such as:
- Adding, updating, deleting, and listing products.

### Cart-Service
Handles shopping cart functionalities:
- Adding products to the cart.
- Managing the cart items.

### Order-Service
Manages customer orders:
- Creating, viewing, and processing orders.

## Databases and Caching

- **MySQL**: Handles relational data, such as product and order details.
- **MongoDB**: Stores non-relational data.
- **Redis**: Provides caching and session management for faster response times.

## Deployment

1. **Build Docker Images**:
    - Build the Docker images for each microservice:
      ```bash
      docker build -t <username>/beautybay-product-service:latest ./product-service
      docker build -t <username>/beautybay-cart-service:latest ./cart-service
      docker build -t <username>/beautybay-order-service:latest ./order-service
      ```

2. **Push Images to Docker Hub**:
   ```bash
   docker push <username>/beautybay-product-service:latest
   docker push <username>/beautybay-cart-service:latest
   docker push <username>/beautybay-order-service:latest
   ```

3. **Deploy to Kubernetes**:
    - Apply Kubernetes configurations:
      ```bash
      kubectl apply -f kubernetes/microservices.yaml
      ```

4. **Check Deployment**:
    - Verify that all the services are running:
      ```bash
      kubectl get pods
      ```

## Environment Variables

### ConfigMap
The `laravel-config` ConfigMap contains shared environment variables:
- **APP_ENV**: Application environment.
- **DB_CONNECTION**: MySQL connection details.
- **MONGO_HOST**: MongoDB connection details.
- **REDIS_HOST**: Redis connection details.

### MySQL and MongoDB Credentials:
- **DB_HOST**, **DB_USERNAME**, **DB_PASSWORD** for MySQL.
- **MONGO_HOST**, **MONGO_USERNAME**, **MONGO_PASSWORD** for MongoDB.

## Usage

Once deployed, you can access the microservices via their respective **LoadBalancer** services:
- **Product-Service**: `http://<external-ip>:9000`
- **Cart-Service**: `http://<external-ip>:9000`
- **Order-Service**: `http://<external-ip>:9000`

## Persistent Storage

- **MySQL** and **MongoDB** use persistent volumes to store their data. This ensures data is retained even if the containers are restarted or rescheduled.

## Kubernetes Services

### Internal Services (ClusterIP)
- **MySQL-Service**: Manages internal database connections.
- **MongoDB-Service**: Manages MongoDB connections.
- **Redis-Service**: Provides in-memory caching.

### External Services (LoadBalancer)
- **Product-Service**: Exposes product-related operations externally.
- **Cart-Service**: Exposes cart-related operations externally.
- **Order-Service**: Exposes order-related operations externally.

## Load Balancing

Each microservice has **2 replicas** to ensure high availability. The **LoadBalancer** service distributes incoming requests across these replicas to ensure smooth operation even during high traffic.

---

🎉 Awesome! Now that your **Laravel cart-service gRPC client** successfully communicates with your **Node.js product-service gRPC server**, here's a clean, full `README.md` to document the whole setup:

---

## 📘 Laravel gRPC Client + Node.js gRPC Server Integration

This project shows how to call a gRPC server (in Node.js) from a Laravel (PHP) app using properly generated protobuf files and PSR-4 compliant structure.

---

## 📂 Project Structure

```
microservice-ecommerce/
├── cart-service/           # Laravel app (gRPC client)
│   └── app/
│       ├── Grpc/
│       │   └── Generated/  # Generated gRPC PHP files
│       └── proto/
│           └── Greeter.proto
├── product-service/        # Node.js gRPC server
│   ├── server.cjs
│   └── proto/
│       └── Greeter.proto
```

---

## 🧩 Prerequisites

### Laravel (cart-service):

* PHP ≥ 8.2
* Composer
* `ext-grpc` installed and version-matched with PHP
* `protoc` installed (`protoc --version`)
* `grpc_php_plugin.exe` built or downloaded

### Node.js (product-service):

* Node.js ≥ 18
* `@grpc/grpc-js` and `@grpc/proto-loader` installed

---

## 📝 Greeter.proto (Shared Definition)

**Path:** `app/proto/Greeter.proto` (same file used in Node and PHP)

```proto
syntax = "proto3";

package app;

option php_namespace = "App\\Grpc\\Generated";

service Greeter {
  rpc SayHello (HelloRequest) returns (HelloReply);
}

message HelloRequest {
  string name = 1;
}

message HelloReply {
  string message = 1;
}
```

---

## ⚙️ Generate PHP gRPC Client

### 1. Generate PHP gRPC files into a temp folder:

```powershell
protoc --proto_path=app/proto --php_out=proto_temp --grpc_out=proto_temp --plugin=protoc-gen-grpc="C:\grpc\cmake\build\grpc_php_plugin.exe" app/proto/Greeter.proto
```

### 2. Move files to PSR-4-compliant location:

```powershell
mkdir -Force app\Grpc\Generated\GPBMetadata
Move-Item proto_temp\App\Grpc\Generated\*.php app\Grpc\Generated\
Move-Item proto_temp\GPBMetadata\Greeter.php app\Grpc\Generated\GPBMetadata\
Remove-Item -Recurse -Force proto_temp
```

### 3. Dump Composer autoload:

```bash
composer dump-autoload
```

---

## 🧑‍💻 Laravel Usage Example

**Route example:**

```php
Route::get('/grpc-test', function () {
    $client = new \App\Grpc\Generated\GreeterClient('127.0.0.1:50051', [
        'credentials' => \Grpc\ChannelCredentials::createInsecure()
    ]);

    $request = new \App\Grpc\Generated\HelloRequest();
    $request->setName('Ahmed');

    [$response, $status] = $client->SayHello($request)->wait();

    return $response->getMessage();
});
```

---

## 🚀 Run Node.js gRPC Server

**server.cjs** example:

```js
const grpc = require('@grpc/grpc-js');
const protoLoader = require('@grpc/proto-loader');
const path = require('path');

const packageDef = protoLoader.loadSync(path.join(__dirname, 'proto', 'Greeter.proto'), {
    keepCase: true,
    longs: String,
    enums: String,
    defaults: true,
    oneofs: true
});

const grpcObject = grpc.loadPackageDefinition(packageDef);
const greeter = grpcObject.app.Greeter;

const server = new grpc.Server();
server.addService(greeter.service, {
    SayHello: (call, callback) => {
        callback(null, { message: `Hello ${call.request.name} from product-service` });
    }
});

server.bindAsync('0.0.0.0:50051', grpc.ServerCredentials.createInsecure(), () => {
    console.log('✅ gRPC server running on port 50051');
});
```

Run it:

```bash
node server.cjs
```

---

## 🛠 Troubleshooting

| Error                               | Fix                                                                                                                      |
| ----------------------------------- | ------------------------------------------------------------------------------------------------------------------------ |
| `Failed to parse binary descriptor` | Wrong namespace or invalid `.proto` structure. Use correct `php_namespace`.                                              |
| `Class not found`                   | Files not moved correctly; PSR-4 structure must be exact.                                                                |
| `Connection refused`                | Server not running or Laravel using IPv6. Use `127.0.0.1` not `localhost`.                                               |
| `Method not implemented`            | Package mismatch — Laravel calls `/app.Greeter/SayHello` but Node expects a different package. Must match `package app`. |


---

## 🧱 gRPC PHP Plugin (`grpc_php_plugin.exe`)

The `grpc_php_plugin.exe` is required by `protoc` to generate the PHP gRPC client stubs (like `GreeterClient.php`).

---

### 📍 Path in This Setup:

```text
C:\grpc\cmake\build\grpc_php_plugin.exe
```

You specify it in the `protoc` command like this:

```bash
--plugin=protoc-gen-grpc="C:\grpc\cmake\build\grpc_php_plugin.exe"
```

---

## 🛠️ How to Get or Rebuild It

### ✅ Option 1: Download a Prebuilt Version (Recommended)

You can download a precompiled `grpc_php_plugin.exe` from official GitHub Releases:

1. Visit: [https://github.com/grpc/grpc/releases](https://github.com/grpc/grpc/releases)
2. Find a version (e.g. `v1.60.x`) and download:

   ```
   grpc_php_plugin.exe
   ```
3. Place it somewhere permanent like:

   ```
   C:\grpc\cmake\build\
   ```

---

### 🔧 Option 2: Build from Source (Advanced)

If you prefer or need to build it yourself:

Certainly! Here's a full, detailed breakdown for:

---

## 🔧 Option 2: Build `grpc_php_plugin.exe` from Source (Advanced)

This guide will walk you through building the `grpc_php_plugin.exe` manually using MSYS2, CMake, and GCC on **Windows**.

---

### 🧱 Why build from source?

If the official binary isn’t available or you want full control over the version (for compatibility), you can compile it yourself using open-source tools.

---

## 🖥️ System Requirements

* Windows 10 or 11
* At least 2 GB free disk space
* Admin privileges to install MSYS2 and packages

---

## ✅ Step-by-Step Guide

### 🔽 1. Install MSYS2

Download and install MSYS2 from:

📦 [https://www.msys2.org](https://www.msys2.org)

Install the **x86\_64** version (not ARM).

After installation, launch:

> `MSYS2 UCRT64` terminal (not MSYS or MINGW32)

Then run:

```bash
pacman -Syu
```

If it asks to restart MSYS2, close and reopen it, then run again:

```bash
pacman -Syu
```

---

### 📦 2. Install required packages

In your MSYS2 UCRT64 terminal:

```bash
pacman -S --needed git cmake make nasm \
  mingw-w64-x86_64-toolchain \
  mingw-w64-x86_64-cmake \
  mingw-w64-x86_64-make
```

This installs:

* GCC
* CMake (MinGW)
* Make
* NASM (for boringssl)
* All build dependencies

---

### 📁 3. Clone the gRPC source code (with submodules)

In a working folder like `C:\grpc`, run:

```bash
cd /c
git clone --recurse-submodules -b v1.60.0 https://github.com/grpc/grpc.git
```

💡 Replace `v1.60.0` with your desired gRPC version tag.

---

### 🏗️ 4. Create the build directory

Inside the cloned folder:

```bash
cd /c/grpc
mkdir -p cmake/build
cd cmake/build
```

---

### ⚙️ 5. Run CMake configuration

Now configure CMake with MinGW:

```bash
cmake -G "MinGW Makefiles" -DCMAKE_POLICY_VERSION_MINIMUM=3.5 ../..
```

✅ Expected output:

* Should detect compilers (`cc.exe`, `c++.exe`)
* Should complete with `-- Configuring done`

---

### 🧪 6. Build the plugin

This is the final step:

```bash
mingw32-make grpc_php_plugin
```

💡 It will take several minutes depending on your CPU.

✅ When complete, the file will be located at:

```bash
/c/grpc/cmake/build/grpc_php_plugin.exe
```

Or in Windows terms:

```text
C:\grpc\cmake\build\grpc_php_plugin.exe
```

---

### ✅ 7. Test the plugin

From PowerShell or terminal:

```bash
C:\grpc\cmake\build\grpc_php_plugin.exe --version
```

If no error appears, it's ready to use.

---

## ✅ Usage Example

Use it in your Laravel gRPC command like this:

```powershell
protoc --proto_path=app/proto --php_out=proto_temp --grpc_out=proto_temp --plugin=protoc-gen-grpc="C:\grpc\cmake\build\grpc_php_plugin.exe" app/proto/Greeter.proto
```

---

## 🧼 Optional Cleanup

To save space, you can delete intermediate build files:

```bash
rm -rf /c/grpc/cmake/build/*
```

Or keep it for future builds.

---

## 🙌 You're Done!

You now have a custom-built `grpc_php_plugin.exe` compatible with your system, PHP version, and project requirements.

Let me know if you’d like a script to automate the entire build process on Windows.
