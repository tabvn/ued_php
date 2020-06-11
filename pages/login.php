<?php
$values = array('email' => "", 'password' => "");
$errors = null;
$message = null;
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
        $stmt = $db->prepare("SELECT id, email, password,role FROM users where email =? AND password =?");
        $stmt->bind_param("ss", $values['email'], md5($values['password']));
        if (!$stmt->execute()) {
            $message = array('type' => 'error', 'message' => htmlspecialchars($stmt->error));
        } else {
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $id = null;
                $email = null;
                $password = null;
                $role = null;
                $stmt->bind_result($id, $email, $password, $role);
                $result = $stmt->get_result();
                $stmt->fetch();
                var_dump(array($id, $email, $password, $role));
                $_SESSION['user'] = array('id' => $id, 'email' => $email, 'role' => $role);
                $message = array('type' => 'success', 'message' => 'Đăng nhập thành công!');
                header('Location: ' .path('/?p=home'));
                exit();
                // login success
                // create session
            } else {
                $message = array('type' => 'error', "message" => 'Email hoặc mật khẩu không chính xác!');
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
                        <div class="card-header-title">Đăng nhập tài khoản</div>
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
                        <form method="post" action="<?php print path('/index.php?p=login'); ?>">
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
                                <div class="control">
                                    <button type="submit" class="button is-link">Đăng nhập</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>