
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

You can copy-paste this markdown into a file named `README.md` for your project!