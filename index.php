<?php 
// index.php
require_once 'settings/core.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-Commerce Platform - Home</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>E-Commerce Platform</h1>
      <nav class="nav-menu">
        <?php if (!isLoggedIn()): ?>
          <!-- Not logged in menu -->
          <a href="login/register.php" class="nav-link success">Register</a>
          <a href="login/login.php" class="nav-link primary">Login</a>
        <?php elseif (isAdmin()): ?>
          <!-- Admin menu -->
          <span style="color: #28a745; font-weight: bold;">Welcome, Admin!</span>
          <a href="admin/category.php" class="nav-link warning">Categories</a>
          <a href="login/logout.php" class="nav-link danger">Logout</a>
        <?php else: ?>
          <!-- Regular user menu -->
          <span style="color: #007bff; font-weight: bold;">Welcome, User!</span>
          <a href="login/logout.php" class="nav-link danger">Logout</a>
        <?php endif; ?>
      </nav>
    </div>

    <div class="welcome-section">
      <?php if (!isLoggedIn()): ?>
        <h1>Welcome to Our E-Commerce Platform</h1>
        <p>Please register or login to access the full features of our platform.</p>
      <?php elseif (isAdmin()): ?>
        <div class="user-info">
          <h2>Admin Dashboard</h2>
          <p>You have administrative privileges. You can manage categories and oversee the platform.</p>
        </div>
        <h1>Welcome to the Admin Panel</h1>
        <p>Use the navigation menu above to manage your e-commerce platform.</p>
      <?php else: ?>
        <div class="user-info">
          <h2>User Dashboard</h2>
          <p>Welcome back! You are logged in as a regular user.</p>
        </div>
        <h1>Welcome to Our E-Commerce Platform</h1>
        <p>Explore our products and services. More features coming soon!</p>
      <?php endif; ?>
    </div>

    <?php if (isAdmin()): ?>
    <div class="features">
      <div class="feature-card">
        <h3>Category Management</h3>
        <p>Create, edit, and delete product categories. Organize your inventory efficiently with our comprehensive category management system.</p>
      </div>
      <div class="feature-card">
        <h3>User Management</h3>
        <p>Manage user accounts, roles, and permissions. Keep track of your customers and administrative staff.</p>
      </div>
      <div class="feature-card">
        <h3>Analytics & Reports</h3>
        <p>View detailed analytics and generate reports to understand your business performance and make informed decisions.</p>
      </div>
    </div>
    <?php elseif (isLoggedIn()): ?>
    <div class="features">
      <div class="feature-card">
        <h3>Browse Products</h3>
        <p>Explore our wide range of products organized by categories. Find exactly what you're looking for with our advanced search features.</p>
      </div>
      <div class="feature-card">
        <h3>Shopping Cart</h3>
        <p>Add items to your cart and manage your purchases. Secure checkout process with multiple payment options.</p>
      </div>
      <div class="feature-card">
        <h3>Order History</h3>
        <p>Track your orders and view your purchase history. Get updates on shipping and delivery status.</p>
      </div>
    </div>
    <?php else: ?>
    <div class="features">
      <div class="feature-card">
        <h3>Easy Registration</h3>
        <p>Sign up quickly and easily to start shopping. Create your account in just a few simple steps.</p>
      </div>
      <div class="feature-card">
        <h3>Secure Platform</h3>
        <p>Your data and transactions are protected with industry-standard security measures and encryption.</p>
      </div>
      <div class="feature-card">
        <h3>Customer Support</h3>
        <p>Get help when you need it with our dedicated customer support team available to assist you.</p>
      </div>
    </div>
    <?php endif; ?>
  </div>
</body>
</html>
