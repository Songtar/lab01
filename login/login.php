<?php // login/login.php ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="icon" href="data:,">
  <!-- Prevent favicon 404 in some setups -->
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Login</h1>
      <nav class="nav-menu">
        <a href="../index.php" class="nav-link primary">Home</a>
        <a href="register.php" class="nav-link success">Register</a>
      </nav>
    </div>

    <div class="welcome-section text-left no-padding">
      <div class="feature-card accent-green">
        <h3>Sign in to your account</h3>
        <form class="form-stack" onsubmit="event.preventDefault(); alert('Login flow comes in the next lab');">
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="you@example.com" required>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="••••••••" required>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Login</button>
          </div>
        </form>
        <p>Don't have an account? <a class="nav-link success" href="register.php">Register</a></p>
      </div>
    </div>
  </div>
</body>
</html>
