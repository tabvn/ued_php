<?php

if (empty($_GET['id'])) {
    redirect('?p=notfound');
}
$values = array(
    'ten'          => "",
    'ho'           => '',
    'ngay_sinh'    => "",
    'email'        => "",
    'dien_thoai'   => "",
);
$errors = null;
$message = null;

function getTeacher($id)
{
    $id = (int) $id;
    $db = Database::getConnection();

    return $db->query("SELECT id, ten, ho, DATE_FORMAT(ngay_sinh, '%d/%m/%Y') as ngay_sinh, email, dien_thoai FROM giang_vien WHERE id = $id")
        ->fetch_assoc();
}

function editTeacher($values)
{
    $db = Database::getConnection();
    $stmt
        = $db->prepare("UPDATE giang_vien SET ten=?,ho=?,ngay_sinh=?,email=?,dien_thoai=? WHERE id = ?");
    $stmt->bind_param("sssssi", $values['ten'], $values['ho'], $values['ngay_sinh'], $values['email'], $values['dien_thoai'],  $values['id']);
    if ( ! $stmt->execute()) {
        return $stmt->error;
    }
    $stmt->close();

    return null;
}

if ( ! empty($_POST)) {
    $values['ho'] = $_POST['ho'];
    $values['ten'] = $_POST['ten'];
    $values['ngay_sinh'] = $_POST['ngay_sinh'];
    $values['email'] = $_POST['email'];
    $values['dien_thoai'] = $_POST['dien_thoai'];
    $values['id'] = $_GET['id'];
    if (empty($values['ho'])) {
        $errors['ho'] = 'Bạn phải nhập vào Họ';
    }
    if (empty($values['ten'])) {
        $errors['ten'] = 'Bạn phải nhập vào Tên';
    }
    if (empty($values['email'])) {
        $errors['email'] = 'Bạn phải nhập vào Email';
    }
    if (empty($values['dien_thoai'])) {
        $errors['dien_thoai'] = 'Bạn phải nhập vào Số điện thoại';
    }
    if (empty($values['ngay_sinh'])) {
        $errors['ngay_sinh'] = 'Ngày sinh là bắt buộc';
    }

    if ( ! empty($values['ngay_sinh'])) {
        $split = explode("/", $values['ngay_sinh']);
        if (count($split) < 3) {
            $errors['ngay_sinh'] = 'Ngày sinh không đúng!';
        }
        $ns = $split[2] . "-" . $split[1] . '-' . $split[0];
        $values['ngay_sinh'] = $ns;
    }
    if ($errors == null) {
        $error = editTeacher($values);
        if ( ! empty($error)) {
            $message = array(
                'type'    => 'error',
                'message' => "Có lỗi xảy ra:".$error,
            );
        } else {
            $message = array(
                'type'    => 'success',
                'message' => "Cập nhật thành công!",
            );
        }
    }
}
$id = $_GET['id'];
$obj = getTeacher($id);
if (empty($obj)) {
    redirect('?p=notfound');
}
$values['id'] = $obj['id'];
$values['ho'] = $obj['ho'];
$values['ten'] = $obj['ten'];
$values['ngay_sinh'] = $obj['ngay_sinh'];
$values['email'] = $obj['email'];
$values['dien_thoai'] = $obj['dien_thoai'];
require_once "header.php";

?>
<div id="content">
    <div class="container">
        <div class="columns">
            <?php
            require_once "admin_menu.php"; ?>
            <div class="column is-9">
                <div class="columns">
                    <div class="column is-9">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-header-title">Cập nhật giảng viên
                                </div>
                            </div>
                            <div class="card-content">
                                <?php
                                if ( ! empty($message)): ?>
                                    <article
                                            class="message <?php
                                            print $message['type'] == 'error'
                                                ? 'is-danger' : 'is-success' ?>">
                                        <div class="message-body">
                                            <?php
                                            print $message['message']; ?>
                                        </div>
                                    </article>
                                <?php
                                endif; ?>
                                <form method="post" action="<?php
                                print path('/index.php?p=admin/teachers/edit&id=')
                                    .$id; ?>">


                                    <div class="field">
                                        <label class="label">Họ</label>
                                        <div class="control">
                                            <input value="<?php
                                            print $values['ho']; ?>"
                                                   name="ho" class="input"
                                                   type="text" placeholder="Họ"
                                            >
                                            <?php
                                            if ( ! empty($errors['ho'])): ?>
                                                <p class="help is-danger"><?php
                                                    print $errors['ho']; ?></p>
                                            <?php
                                            endif; ?>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label class="label">Tên</label>
                                        <div class="control">
                                            <input value="<?php
                                            print $values['ten']; ?>"
                                                   name="ten" class="input"
                                                   type="text" placeholder="Tên"
                                            >
                                            <?php
                                            if ( ! empty($errors['ten'])): ?>
                                                <p class="help is-danger"><?php
                                                    print $errors['ten']; ?></p>
                                            <?php
                                            endif; ?>

                                        </div>
                                    </div>

                                    <div class="field">
                                        <label class="label">Ngày sinh</label>
                                        <div class="control">
                                            <input value="<?php
                                            print ! empty($_POST['ngay_sinh'])
                                                ? $_POST['ngay_sinh']
                                                : $values['ngay_sinh']; ?>"
                                                   name="ngay_sinh"
                                                   class="input"
                                                   type="text"
                                                   placeholder="DD/MM/YYYY"
                                            >
                                        </div>
                                        <?php
                                        if ( ! empty($errors['ngay_sinh'])): ?>
                                            <p class="help is-danger"><?php
                                                print $errors['ngay_sinh']; ?></p>
                                        <?php
                                        endif; ?>
                                    </div>

                                    <div class="field">
                                        <label class="label">Email</label>
                                        <div class="control">
                                            <input value="<?php
                                            print $values['email']; ?>"
                                                   name="email" class="input"
                                                   type="text" placeholder="Email"
                                            >
                                            <?php
                                            if ( ! empty($errors['email'])): ?>
                                                <p class="help is-danger"><?php
                                                    print $errors['email']; ?></p>
                                            <?php
                                            endif; ?>

                                        </div>
                                    </div>

                                    <div class="field">
                                        <label class="label">SĐT</label>
                                        <div class="control">
                                            <input value="<?php
                                            print $values['dien_thoai']; ?>"
                                                   name="dien_thoai" class="input"
                                                   type="text" placeholder="SĐT"
                                            >
                                            <?php
                                            if ( ! empty($errors['dien_thoai'])): ?>
                                                <p class="help is-danger"><?php
                                                    print $errors['dien_thoai']; ?></p>
                                            <?php
                                            endif; ?>

                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="control">
                                            <button type="submit"
                                                    class="button is-link">Cập
                                                nhật
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>