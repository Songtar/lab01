<?php // login/register.php ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="icon" href="data:,">
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Register</h1>
      <nav class="nav-menu">
        <a href="../index.php" class="nav-link primary">Home</a>
        <a href="login.php" class="nav-link">Login</a>
      </nav>
    </div>

    <div class="welcome-section text-left no-padding">
      <div class="feature-card accent-teal">
        <h3>Create your account</h3>
        <form id="registerForm" enctype="multipart/form-data">
          <div class="form-group">
            <label for="full_name">Full name</label>
            <input type="text" id="full_name" name="full_name" placeholder="Jane Doe" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="you@example.com" required>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="••••••••" required>
          </div>
          <div class="form-group">
            <label for="country">Country</label>
            <input type="text" id="country" name="country" placeholder="Country" required>
          </div>
          <div class="form-group">
            <label for="city">City</label>
            <input type="text" id="city" name="city" placeholder="City" required>
          </div>
          <div class="form-group">
            <label for="contact">Contact number</label>
            <input type="tel" id="contact" name="contact" placeholder="Contact number" required>
          </div>
          <div class="form-group">
            <label for="image">Profile image (optional)</label>
            <input type="file" id="image" name="image" accept="image/*">
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-success">Create account</button>
          </div>
        </form>
        <p>Already have an account? <a class="nav-link primary" href="login.php">Login</a></p>
      </div>
    </div>

    <script src="/js/register.js"></script>
  </div>
</body>
</html>
