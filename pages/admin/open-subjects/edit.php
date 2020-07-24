<?php

if (empty($_GET['id'])) {
    redirect('?p=notfound');
}
$values = array(
    'id'              => "",
    'ten_hoc_phan'    => "",
    'ma_hoc_phan'     => "",
    'so_tin_chi'      => "",
    'so_luong_toi_da' => "",
    'thu'             => "",
    'tiet_bat_dau'    => "",
    'tiet_ket_thuc'   => "",
);
$errors = null;
$message = null;

function getSubject($id)
{
    $id = (int) $id;
    $db = Database::getConnection();

    return $db->query("SELECT id, ten_hoc_phan, ma_hoc_phan, so_tin_chi, so_luong_toi_da, thu, tiet_bat_dau, tiet_ket_thuc FROM hoc_phan WHERE id = $id")
      ->fetch_assoc();
}

function editSubject($values)
{
    $db = Database::getConnection();
    $stmt = $db->prepare("UPDATE hoc_phan SET ten_hoc_phan=?, ma_hoc_phan=?, so_tin_chi=?, so_luong_toi_da=?, thu=?, tiet_bat_dau=?, tiet_ket_thuc=? WHERE id = ?");
    $stmt->bind_param("ssiisiii", $values['ten_hoc_phan'], $values['ma_hoc_phan'],$values['so_tin_chi'],$values['so_luong_toi_da'],$values['thu'],$values['tiet_bat_dau'],$values['tiet_ket_thuc'],$values['id']);
    if ( ! $stmt->execute()) {
        return $stmt->error;
    }
    $stmt->close();

    return null;
}

if ( ! empty($_POST)) {
    $values['id'] = $_POST['id'];
    $values['ten_hoc_phan'] = $_POST['ten_hoc_phan'];
    $values['ma_hoc_phan'] = $_POST['ma_hoc_phan'];
    $values['so_tin_chi'] = $_POST['so_tin_chi'];
    $values['so_luong_toi_da'] = $_POST['so_luong_toi_da'];
    $values['thu'] = $_POST['thu'];
    $values['tiet_bat_dau'] = $_POST['tiet_bat_dau'];
    $values['tiet_ket_thuc'] = $_POST['tiet_ket_thuc'];
    if (empty($values['id'])) {
        $errors['id'] = 'Bạn phải nhập vào Mã học phần';
    }
    if (empty($values['ten_hoc_phan'])) {
        $errors['ten_hoc_phan'] = 'Bạn phải nhập vào Tên học phần';
    }
    if (empty($values['ma_hoc_phan'])) {
        $errors['ma_hoc_phan'] = 'Bạn phải nhập vào Mã học phần';
    }
    if (empty($values['so_tin_chi'])) {
        $errors['so_tin_chi'] = 'Số tín chỉ là bắt buộc!';
    }
    if (empty($values['so_luong_toi_da'])) {
        $errors['so_luong_toi_da'] = 'Bạn phải nhập số lượng tối đa';
    }
    if (empty($values['thu'])) {
        $errors['thu'] = 'Bạn phải nhập thứ';
    }
    if (empty($values['tiet_bat_dau'])) {
        $errors['tiet_bat_dau'] = 'Bạn phải nhập Tiết bắt đầu';
    }
    if (empty($values['tiet_ket_thuc'])) {
        $errors['tiet_ket_thuc'] = 'Bạn phải nhập Tiết kết thúc';
    }
    if ($errors == null) {
        $error = editSubject($values);
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
$subject = getSubject($id);
if (empty($subject)) {
    redirect('?p=notfound');
}
$values['id'] = $subject['id'];
$values['ten_hoc_phan'] = $subject['ten_hoc_phan'];
$values['ma_hoc_phan'] = $subject['ma_hoc_phan'];
$values['so_tin_chi'] = $subject['so_tin_chi'];
$values['so_luong_toi_da'] = $subject['so_luong_toi_da'];
$values['thu'] = $subject['thu'];
$values['tiet_bat_dau'] = $subject['tiet_bat_dau'];
$values['tiet_ket_thuc'] = $subject['tiet_ket_thuc'];
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
                                <div class="card-header-title">Cập nhật học phần</div>
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
                                print path('/index.php?p=admin/open-subjects/edit&id=' .$id); ?>">
                                    <div class="field">
                                        <input value="<?php
                                        print $values['id']; ?>"
                                               name="id" class="input"
                                               type="hidden"
                                        >
                                    </div>
                                    <div class="field">
                                        <label class="label">Mã học phần</label>
                                        <div class="control">
                                            <input value="<?php
                                            print $values['ma_hoc_phan']; ?>"
                                                   name="ma_hoc_phan"
                                                   class="input"
                                                   type="text"
                                                   placeholder="Mã học phần"
                                            >
                                            <?php
                                            if ( ! empty($errors['ma_hoc_phan'])): ?>
                                                <p class="help is-danger"><?php
                                                    print $errors['ma_hoc_phan']; ?></p>
                                            <?php
                                            endif; ?>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label class="label">Tên học phần</label>
                                        <div class="control">
                                            <input value="<?php
                                            print $values['ten_hoc_phan']; ?>"
                                                   name="ten_hoc_phan"
                                                   class="input"
                                                   type="text"
                                                   placeholder="Tên học phần"
                                            >
                                            <?php
                                            if ( ! empty($errors['ten_hoc_phan'])): ?>
                                                <p class="help is-danger"><?php
                                                    print $errors['ten_hoc_phan']; ?></p>
                                            <?php
                                            endif; ?>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label class="label">Số tín chỉ</label>
                                        <div class="control">
                                            <input value="<?php
                                            print $values['so_tin_chi']; ?>"
                                                   name="so_tin_chi"
                                                   class="input"
                                                   type="text"
                                                   placeholder="Số tín chỉ"
                                            >
                                            <?php
                                            if ( ! empty($errors['so_tin_chi'])): ?>
                                                <p class="help is-danger"><?php
                                                    print $errors['so_tin_chi']; ?></p>
                                            <?php
                                            endif; ?>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label class="label">Số lượng tối đa</label>
                                        <div class="control">
                                            <input value="<?php
                                            print $values['so_luong_toi_da']; ?>"
                                                   name="so_luong_toi_da"
                                                   class="input"
                                                   type="text"
                                                   placeholder="Số lượng tối đa"
                                            >
                                            <?php
                                            if ( ! empty($errors['so_luong_toi_da'])): ?>
                                                <p class="help is-danger"><?php
                                                    print $errors['so_luong_toi_da']; ?></p>
                                            <?php
                                            endif; ?>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label class="label">Thứ</label>
                                        <div class="control">
                                            <input value="<?php
                                            print $values['thu']; ?>"
                                                   name="thu"
                                                   class="input"
                                                   type="text"
                                                   placeholder="Thứ"
                                            >
                                            <?php
                                            if ( ! empty($errors['thu'])): ?>
                                                <p class="help is-danger"><?php
                                                    print $errors['thu']; ?></p>
                                            <?php
                                            endif; ?>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label class="label">Tiết bắt đầu</label>
                                        <div class="control">
                                            <input value="<?php
                                            print $values['tiet_bat_dau']; ?>"
                                                   name="tiet_bat_dau"
                                                   class="input"
                                                   type="text"
                                                   placeholder="Tiết bắt đầu"
                                            >
                                            <?php
                                            if ( ! empty($errors['tiet_bat_dau'])): ?>
                                                <p class="help is-danger"><?php
                                                    print $errors['tiet_bat_dau']; ?></p>
                                            <?php
                                            endif; ?>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label class="label">Tiết kết thúc</label>
                                        <div class="control">
                                            <input value="<?php
                                            print $values['tiet_ket_thuc']; ?>"
                                                   name="tiet_ket_thuc"
                                                   class="input"
                                                   type="text"
                                                   placeholder="Tiết kết thúc"
                                            >
                                            <?php
                                            if ( ! empty($errors['tiet_ket_thuc'])): ?>
                                                <p class="help is-danger"><?php
                                                    print $errors['tiet_ket_thuc']; ?></p>
                                            <?php
                                            endif; ?>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="control">
                                            <button type="submit"
                                                    class="button is-link">Câp nhật học phần
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