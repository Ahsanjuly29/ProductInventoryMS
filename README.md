

## Clone the Project

```bash
   git clone [https://github.com/Ahsanjuly29/ProductInventoryMS.git](https://github.com/Ahsanjuly29/ProductInventoryMS.git)
   cd <repo-name>
```

## Install Dependencies
```bash
   composer install
```

## Copy Environment File
```bash
   cp .env.example .env
```

## Generate App Key & JWT Secret
```bash
   php artisan key:generate
   php artisan jwt:secret
```

## Run Migrations & Seeders
```bash
   php artisan migrate --seed
```

## Start Queue Worker
```bash
   php artisan queue:work
```

##  Start Server
```bash
   php artisan serve
```

---

# 🔑 API Authentication Guide

### After login/register you will receive a JWT token.  
Send it in every protected request:

```bash
   Authorization: Bearer <token>
```

### Refresh token:
```bash
   POST /api/v1/auth/refresh
```

---

# 🚀 API Endpoints

---

## 🔐 Authentication

<table>
  <thead>
    <tr>
      <th>Method</th>
      <th>Endpoint</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>
    <tr><td><strong>POST</strong></td><td><code>/auth/register</code></td><td>Create a new user</td></tr>
    <tr><td><strong>POST</strong></td><td><code>/auth/login</code></td><td>Login user</td></tr>
    <tr><td><strong>POST</strong></td><td><code>/auth/refresh</code></td><td>Refresh access token</td></tr>
    <tr><td><strong>POST</strong></td><td><code>/auth/logout</code></td><td>Logout user</td></tr>
    <tr><td><strong>GET</strong></td><td><code>/auth/me</code></td><td>Get authenticated user</td></tr>
  </tbody>
</table>

---

## 🛒 Products

<table>
  <thead>
    <tr>
      <th>Method</th>
      <th>Endpoint</th>
      <th>Role</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>
    <tr><td><strong>GET</strong></td><td><code>/products</code></td><td>Public</td><td>List all products</td></tr>
    <tr><td><strong>GET</strong></td><td><code>/products/{id}</code></td><td>Public</td><td>Get product details</td></tr>
    <tr><td><strong>POST</strong></td><td><code>/products</code></td><td>Admin / Vendor</td><td>Create a new product</td></tr>
    <tr><td><strong>PUT</strong></td><td><code>/products/{id}</code></td><td>Admin / Vendor</td><td>Update a product</td></tr>
    <tr><td><strong>DELETE</strong></td><td><code>/products/{id}</code></td><td>Admin / Vendor</td><td>Delete a product</td></tr>
  </tbody>
</table>

---

## 📦 Orders

<table>
  <thead>
    <tr>
      <th>Method</th>
      <th>Endpoint</th>
      <th>Role</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>
    <tr><td><strong>POST</strong></td><td><code>/orders</code></td><td>Customer / Vendor / Admin</td><td>Create an order</td></tr>
    <tr><td><strong>GET</strong></td><td><code>/orders</code></td><td>Customer / Vendor / Admin</td><td>List all orders</td></tr>
    <tr><td><strong>GET</strong></td><td><code>/orders/{id}</code></td><td>Customer / Vendor / Admin</td><td>View a specific order</td></tr>
    <tr><td><strong>POST</strong></td><td><code>/orders/{id}/cancel</code></td><td>Customer / Vendor / Admin</td><td>Cancel an order</td></tr>
  </tbody>
</table>

---

 