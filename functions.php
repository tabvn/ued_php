<?php
$base_path = "/ued/";
session_start();
function path($p)
{
    global $base_path;
    if (substr($p, 0, 1) == "/") {
        return $base_path . ltrim($p, "/");
    }
    return $base_path . $p;
}

function redirect($path)
{
    header('Location: ' . path($path));
    exit();
}

function logout()
{
    session_unset();
    session_destroy();
    header('Location: ' . path(""));
    exit();
}

function page()
{
    $filename = __DIR__ . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "home.php";
    $p = !empty($_GET['p']) ? $_GET['p'] : null;
    if (!empty($p)) {
        if (strlen($p) > 0) {
            if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . $p . ".php")) {
                $filename = __DIR__ . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . $p . ".php";
            } else {
                if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . $p . DIRECTORY_SEPARATOR . "index.php")) {
                    $filename = __DIR__ . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . $p . DIRECTORY_SEPARATOR . "index.php";
                }
            }
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