<?php
$base_path = "/ued/";
if (!empty($_GET['p'])) {
    if ($_GET['p'] == 'logout') {
        session_start();
        session_unset();
        session_destroy();
        header('Location: ' . $base_path);
        exit();
    }
}
session_start();
function path($p)
{
    global $base_path;
    if (substr($p, 0, 1) == "/") {
        return $base_path . ltrim($p, "/");
    }
    return $base_path . $p;
}

function page()
{
    $filename = __DIR__ . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "home.php";
    $p = !empty($_GET['p']) ? $_GET['p'] : null;
    if (!empty($p)) {
        if (strlen($p) > 0 && file_exists(__DIR__ . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . $p . ".php")) {
            $filename = __DIR__ . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . $p . ".php";
        } else {
            $filename = __DIR__ . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "notfound.php";
        }
    }
    require_once $filename;
}

function startsWith($haystack, $needle)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}

function getCurrentUser()
{
    if (empty($_SESSION['user'])) {
        return null;
    }
    return $_SESSION['user'];
}