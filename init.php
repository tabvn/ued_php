<?php
// khởi tạo quản trị viên nếu chưa có
require_once "database.php";
$db = Database::getConnection();
$result = $db->query("SELECT COUNT(id) AS total FROM users WHERE role ='admin'")
  ->fetch_assoc();
if ($result['total'] > 0) {
    return;
}
$password = md5("admin");
$email = "admin@gmail.com";
$db->query("INSERT INTO users (email, password) VALUES ('$email', '$password')");