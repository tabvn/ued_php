<?php
$base_path = "/ued/";

function path($p)
{
    global $base_path;
    if (substr($p, 0, 1) == "/") {
        return $base_path . ltrim($p, "/");
    }
    return $base_path . $p;
}

function renderPage()
{
    $filename = __DIR__ . "/pages/home.php";
    $p = $_GET['p'];
    if (isset($p)) {
        if (strlen($p) > 0 && file_exists(__DIR__ . "/pages/" . $p . ".php")) {
            $filename = __DIR__ . "/pages/" . $p . ".php";
        } else {
            $filename = __DIR__ . "/pages/notfound.php";
        }
    }
    require_once $filename;
}