<?php

<<<<<<< HEAD


=======
>>>>>>> 265236428fd06e84c05ae3114161e9c14886aea2
if (empty($_GET['id'])) {
    redirect('?p=notfound');
}
$values = array(
<<<<<<< HEAD
  'id'          => "",
  'email' => "",
  'password' => "",
  'ma_sinh_vien' => "",
  'ten' =>  "",
  'ho' => "",

  'lop' => "",

=======
  'ma_sinh_vien' => '',
  'ten'          => "",
  'ho'           => '',
  'ngay_sinh'    => "",
  'lop'          => "",
>>>>>>> 265236428fd06e84c05ae3114161e9c14886aea2
);
$errors = null;
$message = null;

<<<<<<< HEAD
function getSubject($id)
=======
function getStudent($id)
>>>>>>> 265236428fd06e84c05ae3114161e9c14886aea2
{
    $id = (int) $id;
    $db = Database::getConnection();

<<<<<<< HEAD
    return $db->query("SELECT id, email FROM users WHERE id = $id")
      ->fetch_assoc();
}

function editSubject($values)
{
    $db = Database::getConnection();
    $hash =md5($values['password']);
    $stmt = $db->prepare("UPDATE ued.sinh_vien SET ma_sinh_vien =? ,ten =? ,ho=?,lop=? WHERE user_id = ?");
    $stmt->bind_param("ssssi", $values['ma_sinh_vien'], $values['ten'],$values['ho'],$values['lop'],$id);
=======
    return $db->query("SELECT id,ma_sinh_vien, ten, ho, DATE_FORMAT(ngay_sinh, '%d/%m/%Y') as ngay_sinh,lop FROM sinh_vien WHERE id = $id")
      ->fetch_assoc();
}

function editStudent($values)
{
    $db = Database::getConnection();
    $stmt
      = $db->prepare("UPDATE sinh_vien SET ma_sinh_vien=?,ten=?,ho=?,ngay_sinh=?,lop=? WHERE id = ?");
    $stmt->bind_param("sssssi", $values['ma_sinh_vien'], $values['ten'],
      $values['ho'], $values['ngay_sinh'], $values['lop'], $values['id']);
>>>>>>> 265236428fd06e84c05ae3114161e9c14886aea2
    if ( ! $stmt->execute()) {
        return $stmt->error;
    }
    $stmt->close();

    return null;
}

if ( ! empty($_POST)) {
<<<<<<< HEAD
  //  $values['id'] = $_POST['id'];
    $values['email'] = $_POST['email'];
    $values['password'] =$_POST['password'];
    if (empty($values['password'])) {
        $errors['password'] = 'Bạn phải nhập password';
    }
    if (empty($values['email'])) {
        $errors['email'] = 'Bạn phải nhập vào Email';
    }
    if ($errors == null) {
        $error = editSubject($values);
=======
    $values['lop'] = $_POST['lop'];
    $values['ma_sinh_vien'] = $_POST['ma_sinh_vien'];
    $values['ngay_sinh'] = $_POST['ngay_sinh'];
    $values['ho'] = $_POST['ho'];
    $values['ten'] = $_POST['ten'];
    $values['id'] = $_GET['id'];
    if (empty($values['lop'])) {
        $errors['lop'] = "Lớp là bắt buộc";
    }

    if (empty($values['ngay_sinh'])) {
        $errors['ngay_sinh'] = 'Ngày sinh là bắt buộc';
    }

    if (empty($values['ma_sinh_vien'])) {
        $errors['ma_sinh_vien'] = 'Mã sinh viên là bắt buộc';
    }
    if (empty($values['ho'])) {
        $errors['ho'] = 'Bạn phải nhập vào Họ';
    }
    if (empty($values['ten'])) {
        $errors['ten'] = 'Bạn phải nhập vào Tên';
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
        $error = editStudent($values);
>>>>>>> 265236428fd06e84c05ae3114161e9c14886aea2
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
<<<<<<< HEAD
$user = getSubject($id);
if (empty($user)) {
    redirect('?p=notfound');
}
$values['id'] = $user['id'];
$values['email'] = $user['email'];

require_once "header.php";

?>

<div id="content">
    <div class="container">
        <div class="columns">
            <?php require_once "admin_menu.php"; ?>
=======
$obj = getStudent($id);
if (empty($obj)) {
    redirect('?p=notfound');
}
$values['id'] = $obj['id'];
$values['ma_sinh_vien'] = $obj['ma_sinh_vien'];
$values['ho'] = $obj['ho'];
$values['ten'] = $obj['ten'];
$values['ngay_sinh'] = $obj['ngay_sinh'];
$values['lop'] = $obj['lop'];
require_once "header.php";

?>
<div id="content">
    <div class="container">
        <div class="columns">
            <?php
            require_once "admin_menu.php"; ?>
>>>>>>> 265236428fd06e84c05ae3114161e9c14886aea2
            <div class="column is-9">
                <div class="columns">
                    <div class="column is-9">
                        <div class="card">
                            <div class="card-header">
<<<<<<< HEAD
                                <div class="card-header-title">Cập nhật sinh viên</div>
                            </div>
                            <div class="card-content">
                                <?php if (!empty($message)): ?>
                                    <article
                                        class="message <?php print $message['type'] == 'error' ? 'is-danger' : 'is-success' ?>">
                                        <div class="message-body">
                                            <?php print $message['message']; ?>
                                        </div>
                                    </article>
                                <?php endif; ?>
                                <form method="post" action="<?php print path('/index.php?p=admin/students/edit&id=').$id; ?>">
                                    <div class="field">
                                        <label class="label">Email</label>
                                        <div class="control">
                                            <input name="email"
                                                   class="input <?php print !empty($errors['email']) ? "is-danger" : ""; ?>"
                                                   type="email" placeholder="Địa chỉ email"
                                                   value="<?php print $values['email'] ?>"
                                            >
                                            <?php if (!empty($errors['email'])): ?>
                                                <p class="help is-danger"><?php print $errors['email']; ?></p>
                                            <?php endif; ?>
                                        </div>

                                    </div>
                                    <div class="field">
                                        <label class="label">Mật khẩu</label>
                                        <div class="control">
                                            <input name="password"
                                                   class="input <?php print !empty($errors['password']) ? 'is-danger' : ''; ?>"
                                                   type="password" placeholder="Mật khẩu"
                                                   value="<?php print !empty($_POST['password']) ? $_POST['password'] : ""; ?>"
                                            >
                                            <?php if (!empty($errors['password'])): ?>
                                                <p class="help is-danger"><?php print $errors['password']; ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
=======
                                <div class="card-header-title">Cập nhật sinh
                                    viên
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
                                print path('/index.php?p=admin/students/edit&id=')
                                  .$id; ?>">

>>>>>>> 265236428fd06e84c05ae3114161e9c14886aea2

                                    <div class="field">
                                        <label class="label">Họ</label>
                                        <div class="control">
<<<<<<< HEAD
                                            <input value="<?php print $values['ho']; ?>"
                                                   name="ho" class="input"
                                                   type="text" placeholder="Họ"
                                            >
                                            <?php if (!empty($errors['ho'])): ?>
                                                <p class="help is-danger"><?php print $errors['ho']; ?></p>
                                            <?php endif; ?>
=======
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
>>>>>>> 265236428fd06e84c05ae3114161e9c14886aea2
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label class="label">Tên</label>
                                        <div class="control">
<<<<<<< HEAD
                                            <input value="<?php print $values['ten']; ?>"
                                                   name="ten" class="input"
                                                   type="text" placeholder="Tên"
                                            >
                                            <?php if (!empty($errors['ten'])): ?>
                                                <p class="help is-danger"><?php print $errors['ten']; ?></p>
                                            <?php endif; ?>
=======
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
>>>>>>> 265236428fd06e84c05ae3114161e9c14886aea2

                                        </div>
                                    </div>

                                    <div class="field">
                                        <label class="label">Ngày sinh</label>
                                        <div class="control">
<<<<<<< HEAD
                                            <input value="<?php print !empty($_POST['ngay_sinh']) ? $_POST['ngay_sinh'] : ""; ?>"
                                                   name="ngay_sinh" class="input"
                                                   type="text" placeholder="DD/MM/YYYY"
                                            >
                                        </div>
                                        <?php if (!empty($errors['ngay_sinh'])): ?>
                                            <p class="help is-danger"><?php print $errors['ngay_sinh']; ?></p>
                                        <?php endif; ?>
                                    </div>

                                    <div class="field">
                                        <label class="label">Mã Sinh viên</label>
                                        <div class="control">
                                            <input value="<?php print $values['ma_sinh_vien']; ?>"
                                                   name="ma_sinh_vien"
                                                   class="input <?php print !empty($errors['ma_sinh_vien']) ? 'is-danger' : ''; ?>"
                                                   type="text" placeholder="Mã sinh viên"
                                            >
                                            <?php if (!empty($errors['ma_sinh_vien'])): ?>
                                                <p class="help is-danger"><?php print $errors['ma_sinh_vien']; ?></p>
                                            <?php endif; ?>
=======
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
                                        <label class="label">Mã Sinh
                                            viên</label>
                                        <div class="control">
                                            <input value="<?php
                                            print $values['ma_sinh_vien']; ?>"
                                                   name="ma_sinh_vien"
                                                   class="input <?php
                                                   print ! empty($errors['ma_sinh_vien'])
                                                     ? 'is-danger' : ''; ?>"
                                                   type="text"
                                                   placeholder="Mã sinh viên"
                                            >
                                            <?php
                                            if ( ! empty($errors['ma_sinh_vien'])): ?>
                                                <p class="help is-danger"><?php
                                                    print $errors['ma_sinh_vien']; ?></p>
                                            <?php
                                            endif; ?>
>>>>>>> 265236428fd06e84c05ae3114161e9c14886aea2

                                        </div>
                                    </div>

                                    <div class="field">
                                        <label class="label">Lớp</label>
                                        <div class="control">
                                            <input name="lop"
<<<<<<< HEAD
                                                   class="input <?php print !empty($errors['lop']) ? 'is-danger' : ''; ?>"
                                                   type="text" placeholder="Lớp"
                                                   value="<?php print $values['lop']; ?>">
                                        </div>
                                        <?php if (!empty($errors['lop'])): ?>
                                            <p class="help is-danger"><?php print $errors['lop']; ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="field">
                                        <div class="control">
                                            <button type="submit" class="button is-link">Cập nhật</button>
=======
                                                   class="input <?php
                                                   print ! empty($errors['lop'])
                                                     ? 'is-danger' : ''; ?>"
                                                   type="text" placeholder="Lớp"
                                                   value="<?php
                                                   print $values['lop']; ?>">
                                        </div>
                                        <?php
                                        if ( ! empty($errors['lop'])): ?>
                                            <p class="help is-danger"><?php
                                                print $errors['lop']; ?></p>
                                        <?php
                                        endif; ?>
                                    </div>
                                    <div class="field">
                                        <div class="control">
                                            <button type="submit"
                                                    class="button is-link">Cập
                                                nhật
                                            </button>
>>>>>>> 265236428fd06e84c05ae3114161e9c14886aea2
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