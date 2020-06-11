<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "database.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "functions.php";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UED</title>
    <link rel="stylesheet" href="<?php print path("assets/css/main.css"); ?>">
    <link rel="stylesheet" href="<?php print path("assets/css/style.css"); ?>">
</head>
<body>
<nav class="bd-navbar navbar has-shadow is-spaced" role="navigation" aria-label="main navigation">
    <div class="container">
        <div class="navbar-brand">
            <a class="navbar-item" href="<?php print path("/"); ?>">
                <h1 class="title">UED</h1>
            </a>
            <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false"
               data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start">
                <a class="navbar-item">
                    Trang chủ
                </a>
                <a class="navbar-item">
                    Đăng ký học phần
                </a>
            </div>
            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="buttons">
                        <a class="button is-light" href="<?php print path("/?p=login")?>">
                            Đăng Nhập
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
<?php
page();
?>
</body>