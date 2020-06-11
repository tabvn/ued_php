<?php
$values = array('email' => "", 'password' => "");
$errors = null;
if (!empty($_POST)) {
    $values['email'] = trim($_POST['email']);
    $values['password'] = $_POST['password'];
    if (empty($values['email'])) {
        $errors['email'] = "Địa chỉ email là bắt buộc";
    }
    if (empty($values['password'])) {
        $errors['password'] = "Mật khẩu là bắt buộc";
    }
    if ($errors == null) {
        // handle create user
        $db = Database::getConnection();
        var_dump($db);
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
                                           class="input <?php print !empty($errors['password'] )? 'is-danger' : ''; ?>"
                                           type="password" placeholder="Mật khẩu"
                                           value="<?php print $values['password'] ?>"
                                    >
                                    <?php if (!empty($errors['password'])): ?>
                                        <p class="help is-danger"><?php print $errors['password']; ?></p>
                                    <?php endif; ?>
                                </div>
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