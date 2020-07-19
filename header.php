<?php
$user = getCurrentUser();
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
                <a class="navbar-item" href="<?php print path("/?p=index.php") ?>" >
                    Trang chủ
                </a>
                <a class="navbar-item" href="<?php print path("/?p=subjects") ?>" >
                    Đăng ký học phần
                </a>
               <a class="navbar-item" href="<?php print path("/?p=my-subjects") ?>" >
                    Học phần đã đăng ký
                </a>
            </div>
            <div class="navbar-end">
                <div class="navbar-item">
                    <?php if (!empty($user)): ?>
                        <span class="user-email">
                            <?php print $user['email']; ?>
                        </span>
                    <?php endif; ?>
                    <div class="buttons">
                        <?php if (empty($user)): ?>
                            <a class="button is-light" href="<?php print path("/?p=login") ?>">
                                Đăng Nhập
                            </a>
                        <?php else: ?>
                            <a class="button is-light" href="<?php print path("/?p=logout") ?>">
                                Thoát
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
