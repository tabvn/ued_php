<?php
$user = getCurrentUser();
if (empty($user)) {
    redirect('?p=access-denied');
}
$values = array('email' => $user['email'], 'password' => '');
$errors = null;
$message = null;
if ( ! empty($_POST)) {
    $values['email'] = trim($_POST['email']);
    $values['password'] = $_POST['password'];
    if (empty($values['email'])) {
        $errors['email'] = "Địa chỉ email là bắt buộc";
    }
    if ( ! empty($email)
      && ! filter_var($values['email'], FILTER_VALIDATE_EMAIL)
    ) {
        $errors['email'] = "Địa chỉ email không hợp lệ";
    }
    if ($errors == null) {
        // handle create user
        $id = (int) $user['id'];
        $db = Database::getConnection();
        $sql = "UPDATE users set email =?";
        if ( ! empty($values['password'])) {
            $sql = "UPDATE users set email = ?, password = ?";
        }
        $sql .= " WHERE id = ?";
        $q = $db->prepare($sql);
        if ( ! empty($values['password'])) {
            $password = md5($values['password']);
            $q->bind_param("ssi", $values['email'], $password, $id);
        } else {
            $q->bind_param("si", $values['email'], $id);
        }
        if ($q->execute()) {
            $message = array('type'    => 'success',
                             'message' => 'Cập nhật thông tin thành công!',
            );
            $user['email'] = $values['email'];
            $_SESSION['user'] = $user;
        } else {
            $message = array('type'    => 'success',
                             'message' => 'Lỗi xảy ra: '.$q->error,
            );
        }
        $q->close();
    }
}
require_once "header.php"
?>
<div id="content">
    <div class="container">
        <div class="columns is-mobile is-centered">
            <div class="column is-half">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-title">Cập nhật thông tin</div>
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
                        print currentUrl(); ?>">
                            <div class="field">
                                <label class="label">Email</label>
                                <div class="control">
                                    <input name="email"
                                           class="input <?php
                                           print ! empty($errors['email'])
                                             ? "is-danger" : ""; ?>"
                                           type="email"
                                           placeholder="Địa chỉ email"
                                           value="<?php
                                           print $values['email'] ?>">
                                    <?php
                                    if ( ! empty($errors['email'])): ?>
                                        <p class="help is-danger"><?php
                                            print $errors['email']; ?></p>
                                    <?php
                                    endif; ?>
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Đổi mật khẩu</label>
                                <div class="control">
                                    <input name="password"
                                           class="input <?php
                                           print ! empty($errors['password'])
                                             ? 'is-danger' : ''; ?>"
                                           type="password"
                                           placeholder="Mật khẩu"
                                           value="<?php
                                           print $values['password'] ?>"
                                    >
                                    <?php
                                    if ( ! empty($errors['password'])): ?>
                                        <p class="help is-danger"><?php
                                            print $errors['password']; ?></p>
                                    <?php
                                    endif; ?>
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <button type="submit"
                                            class="button is-link">Lưu thông tin
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