<?php
$user = getCurrentUser();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UED</title>
    <link rel="stylesheet" href="<?php
    print path("assets/css/main.css"); ?>">
    <link rel="stylesheet" href="<?php
    print path("assets/css/style.css"); ?>">
    <script type="text/javascript" src="<?php print path("assets/js/main.js"); ?>"></script>
</head>
<body>
<nav class="bd-navbar navbar has-shadow is-spaced" role="navigation"
     aria-label="main navigation">
    <div class="container">
        <div class="navbar-brand">
            <a class="navbar-item" href="<?php
            print path("/"); ?>">
                <h1 class="title">UED</h1>
            </a>
            <a role="button" class="navbar-burger burger" aria-label="menu"
               aria-expanded="false"
               data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
            <?php
            if ( ! empty($user)): ?>
                <div class="navbar-start">
                    <?php
                    if ($user['role'] == 'student'): ?>
                        <?php
                        print navLink("Đăng ký học phần", '?p=subjects', 'navbar-item') ?>
                        <?php
                        print navLink("Học phần đã đăng ký",
                          '?p=my-subjects', 'navbar-item') ?>
                    <?php
                    endif; ?>
                    <?php
                    if ($user['role'] == 'admin'): ?>
                        <?php print navLink("Giảng viên", '?p=admin/teachers', 'navbar-item') ?>
                        <?php print navLink("Sinh viên", '?p=admin/students', 'navbar-item') ?>
                        <?php print navLink("Môn học", '?p=admin/subjects', 'navbar-item') ?>
                        <?php print navLink("Học phần đang mở", '?p=admin/open-subjects', 'navbar-item') ?>
                        <?php print navLink("Quản trị viên", '?p=admin/users', 'navbar-item') ?>
                    <?php
                    endif; ?>
                </div>
            <?php
            endif; ?>
            <div class="navbar-end">
                <div class="navbar-item">
                    <?php
                    if ( ! empty($user)): ?>
                        <span class="user-email">
                            <?php
                            print $user['email']; ?>
                        </span>
                    <?php
                    endif; ?>
                    <div class="buttons">
                        <?php
                        if (empty($user)): ?>
                            <a class="button is-light" href="<?php
                            print path("/?p=login") ?>">
                                Đăng Nhập
                            </a>
                        <?php
                        else: ?>
                            <a class="button is-white" href="<?php
                            print path("/?p=profile") ?>">
                                Thông tin cá nhân
                            </a>
                            <a class="button is-light" href="<?php
                            print path("/?p=logout") ?>">
                                Thoát
                            </a>
                        <?php
                        endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
