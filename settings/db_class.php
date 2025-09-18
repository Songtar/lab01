<?php
// settings/db_class.php
require_once __DIR__ . '/db_cred.php';

class db_connection {
  protected PDO $db;

  public function __construct() {
    $dsn = 'mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $opts = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $this->db = new PDO($dsn, DB_USERNAME, DB_PASSWORD, $opts);
  }
}
