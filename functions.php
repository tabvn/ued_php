<?php
$base_path = PATH;
session_start();
function path($p)
{
    global $base_path;
    $prefix = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https"
        : "http")."://";
    if (substr($p, 0, 1) == "/") {
        return $prefix.$_SERVER['HTTP_HOST'].$base_path.ltrim($p, "/");
    }

    return $prefix.$_SERVER['HTTP_HOST'].$base_path.$p;
}

function redirect($path)
{
    header('Location: '.path($path));
    exit();
}

function logout()
{
    session_unset();
    session_destroy();
    header('Location: '.path(""));
    exit();
}

function page()
{
    $filename = __DIR__.DIRECTORY_SEPARATOR."pages".DIRECTORY_SEPARATOR
      ."home.php";
    $p = ! empty($_GET['p']) ? $_GET['p'] : null;
    if ( ! empty($p)) {
        if (strlen($p) > 0) {
            if (file_exists(__DIR__.DIRECTORY_SEPARATOR."pages"
              .DIRECTORY_SEPARATOR.$p.".php")
            ) {
                $filename = __DIR__.DIRECTORY_SEPARATOR."pages"
                  .DIRECTORY_SEPARATOR.$p.".php";
            } else {
                if (file_exists(__DIR__.DIRECTORY_SEPARATOR."pages"
                  .DIRECTORY_SEPARATOR.$p.DIRECTORY_SEPARATOR."index.php")
                ) {
                    $filename = __DIR__.DIRECTORY_SEPARATOR."pages"
                      .DIRECTORY_SEPARATOR.$p.DIRECTORY_SEPARATOR."index.php";
                }
            }
        } else {
            $filename = __DIR__.DIRECTORY_SEPARATOR."pages".DIRECTORY_SEPARATOR
              ."notfound.php";
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

function currentUrl()
{
    return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https"
        : "http")."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
}

function isAdminPage()
{
    $p = ! empty($_GET) && ! empty($_GET['p']) ? $_GET['p'] : '';
    if (startsWith($p, "/admin") || startsWith($p, 'admin/')) {
        return true;
    }

    return false;
}

function navLink($title, $path, $defaultClass)
{
    $class = "link-item";
    if ( ! empty($defaultClass)) {
        $class .= " ".$defaultClass;
    }
    $p = path($path);
    if ($p == currentUrl()) {
        $class .= " is-active";
    }

    return '<a class="'.$class.'" href="'.$p.'">'.$title.'</a>';
}