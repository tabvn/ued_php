<?php

ini_set('error_reporting', -1);
ini_set('display_errors', 1);
ini_set('html_errors', 1);
require_once "config.php";
require_once "database.php";
require_once "functions.php";
$user = getCurrentUser();
if (isAdminPage()) {
    if (empty($user)) {
        redirect('?p=access-denied');
    }
    if($user['role'] != 'admin'){
        redirect('?p=access-denied');
    }
}
page();
require_once "footer.php";
