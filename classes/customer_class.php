<?php
// classes/customer_class.php
require_once __DIR__ . '/../settings/db_class.php';

class Customer extends db_connection {
  public function createCustomer($name, $email, $passwordHash, $country, $city, $contact, $imagePath = null, $role = 2) {
    $sql = "INSERT INTO customer
      (customer_name, customer_email, customer_pass, customer_country, customer_city, customer_contact, customer_image, user_role)
      VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([$name, $email, $passwordHash, $country, $city, $contact, $imagePath, $role]);
  }

  public function findByEmail($email) {
    $stmt = $this->db->prepare("SELECT customer_id FROM customer WHERE customer_email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch(); // returns array or false
  }
}
