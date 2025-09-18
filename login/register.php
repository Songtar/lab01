<?php // login/register.php ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Register</title>
</head>
<body>
  <h2>Create Account</h2>
  <form id="registerForm" enctype="multipart/form-data">
    <input type="text"     id="full_name" name="full_name" placeholder="Full name" required><br>
    <input type="email"    id="email"     name="email"     placeholder="Email" required><br>
    <input type="password" id="password"  name="password"  placeholder="Password" required><br>

    <input type="text" id="country" name="country" placeholder="Country" required><br>
    <input type="text" id="city"    name="city"    placeholder="City" required><br>
    <input type="tel"  id="contact" name="contact" placeholder="Contact number" required><br>

    <input type="file" id="image" name="image" accept="image/*"><br>

    <button type="submit">Create account</button>
  </form>

  <p>Already have an account? <a href="/login/login.php">Login</a></p>

  <script src="/js/register.js"></script>
</body>
</html>
