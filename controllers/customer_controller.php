<?php
// controllers/customer_controller.php
require_once __DIR__ . '/../classes/customer_class.php';

function get_customer_by_email_ctr($email) {
  $m = new Customer();
  return $m->findByEmail($email);
}

function register_customer_ctr($name, $email, $passwordHash, $country, $city, $contact, $imagePath = null, $role = 2) {
  $m = new Customer();
  return $m->createCustomer($name, $email, $passwordHash, $country, $city, $contact, $imagePath, $role);
}
