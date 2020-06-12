<?php
$values = array('email' => "", 'password' => "");
$errors = null;
$message = null;

function createStudent($userId, $values)
{
    $db = Database::getConnection();
    $stmt = $db->prepare("INSERT sinh_vien SET ma_sinh_vien = ?, ten =?, ho =?, ngay_sinh=?, lop=?,user_id=?");
    $stmt->bind_param("ssssss", $values['ma_sinh_vien'], $values['ten'], $values['ho'], $values['ngay_sinh'], $values['lop'], $userId);
    if (!$stmt->execute()) {
        return $stmt->error;
    }
    $stmt->close();
    return null;
}

if (!empty($_POST)) {
    $values['email'] = trim($_POST['email']);
    $values['password'] = $_POST['password'];
    $values['ho'] = $_POST['ho'];
    $values['ten'] = $_POST['ten'];
    $values['ma_sinh_vien'] = $_POST['ma_sinh_vien'];
    $values['ngay_sinh'] = $_POST['ngay_sinh'];
    if(!empty($values['ngay_sinh'])){
        //25/10/1987
        //1987-10-25
        $split = explode("/", $values['ngay_sinh']);
        if(count($split) < 3){
            $errors['ngay_sinh'] = 'Ngày sinh không đúng!';
        }
        $ns = $split[2] . "-" . $split[1] . '-' .$split[0];
        $values['ngay_sinh']= $ns;
    }
    $values['lop'] = $_POST['lop'];
    if (empty($values['email'])) {
        $errors['email'] = "Địa chỉ email là bắt buộc";
    }
    if (empty($values['password'])) {
        $errors['password'] = "Mật khẩu là bắt buộc";
    }
    if (empty($values['lop'])) {
        $errors['lop'] = 'Lớp là bắt buộc';
    }
    if ($errors == null) {
        // handle create user
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT users SET email = ?, password =?, role ='student'");
        $stmt->bind_param("ss", $values['email'], md5($values['password']));
        if (!$stmt->execute()) {
            if (endsWith($stmt->error, "'email_UNIQUE'")) {
                $message = array('type' => 'error', 'message' => "Địa chỉ email đã tồn tại");
            }
        } else {
            var_dump($db->insert_id);
            // tao vao bang sinh vien
            $error = createStudent($db->insert_id, $values);
            if (!empty($error)) {
                $message = array('type' => 'error', 'message' => "Có lỗi xảy ra:" . $error);
            }else{
                $message = array('type' => 'success', 'message' => "Tạo tài khoản " . $values['email'] . " thành công!");
            }
        }
        $stmt->close();
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
                                <div class="control has-icons-left has-icons-right">
                                    <input name="email"
                                           class="input <?php print !empty($errors['email']) ? "is-danger" : ""; ?>"
                                           type="email" placeholder="Địa chỉ email"
                                           value="<?php print $values['email'] ?>">
                                    <?php if (!empty($errors['email'])): ?>
                                        <p class="help is-danger"><?php print $errors['email']; ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Mật khẩu</label>
                                <div class="control has-icons-left has-icons-right">
                                    <input name="password"
                                           class="input <?php print !empty($errors['password']) ? 'is-danger' : ''; ?>"
                                           type="password" placeholder="Mật khẩu"
                                           value="<?php print $values['password'] ?>"
                                    >
                                    <?php if (!empty($errors['password'])): ?>
                                        <p class="help is-danger"><?php print $errors['password']; ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Họ</label>
                                <div class="control">
                                    <input value="<?php print $values['ho'];?>" name="ho" class="input" type="text" placeholder="Họ">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Tên</label>
                                <div class="control">
                                    <input value="<?php print $values['ten'];?>" name="ten" class="input" type="text" placeholder="Tên">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Ngày sinh</label>
                                <div class="control">
                                    <input name="ngay_sinh" class="input" type="text" placeholder="DD/MM/YYYY">
                                </div>
                                <?php if (!empty($errors['ngay_sinh'])): ?>
                                    <p class="help is-danger"><?php print $errors['ngay_sinh']; ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="field">
                                <label class="label">Mã Sinh viên</label>
                                <div class="control">
                                    <input name="ma_sinh_vien" class="input" type="text" placeholder="Mã sinh viên">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Lớp</label>
                                <div class="control">
                                    <input name="lop"
                                           class="input <?php print !empty($errors['lop']) ? 'is-danger' : ''; ?>"
                                           type="text" placeholder="Lớp">
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