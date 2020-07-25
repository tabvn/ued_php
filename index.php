<?php

ini_set('error_reporting', -1);
ini_set('display_errors', 1);
ini_set('html_errors', 1);
require_once "config.php";
require_once "database.php";
require_once "functions.php";
function initSuperAdmin()
{
    $db = Database::getConnection();
    $result
      = $db->query("SELECT COUNT(id) AS total FROM users WHERE role ='admin'")
      ->fetch_assoc();
    if ($result['total'] > 0) {
        return;
    }
    $password = md5("admin");
    $email = "admin@gmail.com";
    $db->query("INSERT INTO users (email, password, role) VALUES ('$email', '$password', 'admin')");
}

if ( ! empty($_GET) && ! empty($_GET['p'])) {
    if ($_GET['p'] == 'init') {
        initSuperAdmin();
    }
}
$user = getCurrentUser();
if (isAdminPage()) {
    if (empty($user)) {
        redirect('?p=access-denied');
    }
    if ($user['role'] != 'admin') {
        redirect('?p=access-denied');
    }
}
page();
require_once "footer.php";
