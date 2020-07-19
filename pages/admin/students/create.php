<?php
$values = array(
    'ho' => '',
    'ma_sinh_vien' => '',
    'ngay_sinh' => "",
    'lop' => "",
    'email' => "",
    'password' => "",
    'ten' => "",
);
$errors = null;
$message = null;

function createStudent($userId, $values)
{
    $values['lop'] = strtoupper($values['lop']);
    $db = Database::getConnection();
    $stmt = $db->prepare("INSERT INTO sinh_vien (ma_sinh_vien, ten, ho, ngay_sinh, lop, user_id) VALUES (?, ?, ?, ?, ?, ?)");
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
    if (!empty($values['email']) && !filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Địa chỉ email không hợp lệ";
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
        $errors['ten'] = 'Bạn phải nhập vào Tên';
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
        $hash = md5($values['password']);
        $db = Database::getConnection();
        $db->begin_transaction();
        $stmt = $db->prepare("INSERT INTO users (email, password, role) VALUES (?,?,'student')");
        $stmt->bind_param("ss", $values['email'], $hash);
        if (!$stmt->execute()) {
            if (endsWith($stmt->error, "'email_UNIQUE'")) {
                $message = array('type' => 'error', 'message' => "Địa chỉ email đã tồn tại");
                $errors['email'] = 'Địa chỉ email đã tồn tại';
            }
        } else {
            // tao vao bang sinh vien
            $error = createStudent($db->insert_id, $values);
            if (!empty($error)) {
                $message = array('type' => 'error', 'message' => "Có lỗi xảy ra:" . $error);
                if (endsWith($error, "'ma_sinh_vien_UNIQUE'")) {
                    $message = array('type' => 'error', 'message' => 'Mã sinh viên đã được sử dụng!');
                    $errors['ma_sinh_vien'] = 'Mã sinh viên đã được sử dụng!';
                }
                $db->rollback();
            } else {
                $message = array('type' => 'success', 'message' => "Tạo tài khoản " . $values['email'] . " thành công!");
            }
        }
        $stmt->close();
        $db->commit();
    }
}
require_once "header.php";
?>
<div id="content">
    <div class="container">
        <div class="columns">
            <?php require_once "admin_menu.php"; ?>
            <div class="column is-9">
                <div class="columns">
                    <div class="column is-9">
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
                                <form method="post" action="<?php print path('/index.php?p=admin/students/create'); ?>">
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

                                        </div>
                                    </div>

                                    <div class="field">
                                        <label class="label">Lớp</label>
                                        <div class="control">
                                            <input name="lop"
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

    </div>
</div>