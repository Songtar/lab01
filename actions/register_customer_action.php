<?php
// actions/register_customer_action.php
header('Content-Type: application/json');
require_once __DIR__ . '/../controllers/customer_controller.php';

try {
  // Sanitize inputs
  $name    = trim($_POST['full_name'] ?? '');
  $email   = trim($_POST['email'] ?? '');
  $pass    = $_POST['password'] ?? '';
  $country = trim($_POST['country'] ?? '');
  $city    = trim($_POST['city'] ?? '');
  $contact = trim($_POST['contact'] ?? '');
  $role    = 2; // enforce server-side

  // Basic checks
  if (!$name || !$email || !$pass || !$country || !$city || !$contact) {
    echo json_encode(['status'=>'error','message'=>'All fields are required.']); exit;
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status'=>'error','message'=>'Invalid email.']); exit;
  }

  // Password policy: 8+, upper, digit, special
  $validPwd = strlen($pass) >= 8
           && preg_match('/[A-Z]/', $pass)
           && preg_match('/\d/', $pass)
           && preg_match('/[!@#$%^&*()_\-+={}\[\]|:;"\'<>,.?\/~`]/', $pass);
  if (!$validPwd) {
    echo json_encode(['status'=>'error','message'=>'Password does not meet requirements.']); exit;
  }

  // Unique email
  if (get_customer_by_email_ctr($email)) {
    echo json_encode(['status'=>'error','message'=>'Email already registered.']); exit;
  }

  // Optional image upload
  $imagePath = null;
  if (!empty($_FILES['image']['name'])) {
    $allowed = ['image/jpeg','image/png','image/gif','image/webp'];
    if (!in_array($_FILES['image']['type'], $allowed)) {
      echo json_encode(['status'=>'error','message'=>'Invalid image type.']); exit;
    }
    if ($_FILES['image']['size'] > 2 * 1024 * 1024) {
      echo json_encode(['status'=>'error','message'=>'Image too large (max 2MB).']); exit;
    }
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $fname = 'cust_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    $uploadDir = __DIR__ . '/../uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
    $target = $uploadDir . $fname;
    if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
      echo json_encode(['status'=>'error','message'=>'Failed to save image.']); exit;
    }
    $imagePath = 'uploads/' . $fname;
  }

  $passwordHash = password_hash($pass, PASSWORD_DEFAULT);
  $ok = register_customer_ctr($name, $email, $passwordHash, $country, $city, $contact, $imagePath, $role);

  echo json_encode($ok ? ['status'=>'success'] : ['status'=>'error','message'=>'Database insert failed.']);
} catch (Throwable $e) {
  echo json_encode(['status'=>'error','message'=>'Server error.']);
}
