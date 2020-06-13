<?php
$values = array('ho' => "", 'ma_sinh_vien' => "", 'ngay_sinh' => "", 'lop' => "", 'email' => "", 'password' => "", 'ten' => "");
$errors = null;
$message = null;

function createStudent($userId, $values)
{
    $db = Database::getConnection();
    $stmt = $db->prepare("INSERT sinh_vien SET ma_sinh_vien = ?, ten =?, ho =?, ngay_sinh=?, lop=?,user_id=?");
    $stmt->bind_param("sssssi", $values['ma_sinh_vien'], $values['ten'], $values['ho'], $values['ngay_sinh'], $values['lop'], $userId);
    if (!$stmt->execute()) {
        return $stmt->error;
    }
    $stmt->close();
    return null;
}

if (!empty($_POST)) {
    $values['email'] = trim($_POST['email']);
    $values['password'] = $_POST['password'];
    $values['lop'] = $_POST['lop'];
    $values['ma_sinh_vien'] = $_POST['ma_sinh_vien'];
    $values['ngay_sinh'] = $_POST['ngay_sinh'];
    $values['ho'] = $_POST['ho'];
    $values['ten'] = $_POST['ten'];
    if (empty($values['email'])) {
        $errors['email'] = "Địa chỉ email là bắt buộc";
    }
    if (empty($values['password'])) {
        $errors['password'] = "Mật khẩu là bắt buộc";
    }
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
        $errors['ten'] = 'Bạn phải nhập vào Họ';
    }

    if (!empty($values['ngay_sinh'])) {
        $split = explode("/", $values['ngay_sinh']);
        if (count($split) < 3) {
            $errors['ngay_sinh'] = 'Ngày sinh không đúng!';
        }
        $ns = $split[2] . "-" . $split[1] . '-' . $split[0];
        $values['ngay_sinh'] = $ns;
    }
    if ($errors == null) {
        // handle create user
        $db = Database::getConnection();
        $db->begin_transaction();
        $stmt = $db->prepare("INSERT users SET email = ?, password =?, role ='student'");
        $stmt->bind_param("ss", $values['email'], password_hash($values['password'], PASSWORD_DEFAULT));
        if (!$stmt->execute()) {
            if (endsWith($stmt->error, "'email_UNIQUE'")) {
                $message = array('type' => 'error', 'message' => "Địa chỉ email đã tồn tại");
            }
        } else {
            // tao vao bang sinh vien
            $error = createStudent($db->insert_id, $values);
            if (!empty($error)) {
                $message = array('type' => 'error', 'message' => "Có lỗi xảy ra:" . $error);
                $db->rollback();
            } else {
                $message = array('type' => 'success', 'message' => "Tạo tài khoản " . $values['email'] . " thành công!");
            }
        }
        $stmt->close();
        $db->commit();
    }
}
?>
<div id="content">
    <div class="container">
        <div class="columns is-mobile is-centered">
            <div class="column is-half">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-title">Tạo tài khoản sinh viên</div>
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
                        <form method="post" action="<?php print path('/index.php?p=admin/users/create'); ?>">
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
                                           value="<?php print $_POST['password'] ? $_POST['password'] : ""; ?>"
                                    >
                                    <?php if (!empty($errors['password'])): ?>
                                        <p class="help is-danger"><?php print $errors['password']; ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="field">
                                <label class="label">Họ</label>
                                <div class="control">
                                    <input value="<?php print $values['ho']; ?>"
                                           name="ho" class="input"
                                           type="text" placeholder="Họ"
                                    >
                                    <?php if (!empty($errors['ho'])): ?>
                                        <p class="help is-danger"><?php print $errors['ho']; ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Tên</label>
                                <div class="control">
                                    <input value="<?php print $values['ten']; ?>"
                                           name="ten" class="input"
                                           type="text" placeholder="Tên"
                                    >
                                    <?php if (!empty($errors['ten'])): ?>
                                        <p class="help is-danger"><?php print $errors['ten']; ?></p>
                                    <?php endif; ?>

                                </div>
                            </div>

                            <div class="field">
                                <label class="label">Ngày sinh</label>
                                <div class="control">
                                    <input value="<?php print $_POST['ngay_sinh'] ? $_POST['ngay_sinh'] : ""; ?>"
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
                                           name="ma_sinh_vien" class="input"
                                           type="text" placeholder="Mã sinh viên"
                                    >
                                    <?php if (!empty($errors['ma_sinh_vien'])): ?>
                                        <p class="help is-danger"><?php print $errors['ma_sinh_vien']; ?></p>
                                    <?php endif; ?>

                                </div>
                            </div>

                            <div class="field">
                                <label class="label">Lớp</label>
                                <div class="control">
                                    <input name="lop"
                                           class="input <?php print !empty($errors['lop']) ? 'is-danger' : ''; ?>"
                                           type="text" placeholder="Lớp"
                                           value="<?php print $values['lop']; ?>"
                                    >
                                </div>
                                <?php if (!empty($errors['lop'])): ?>
                                    <p class="help is-danger"><?php print $errors['lop']; ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <button type="submit" class="button is-link">Tạo tài khoản</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>