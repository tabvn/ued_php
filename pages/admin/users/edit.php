<?php



$id = $_GET['id'];

$values = array(
  'email'    => '',
    'password' =>'',
);
$errors = null;
$message = null;

if ( ! empty($_POST)) {
    $values['email'] = trim($_POST['email']);
    $values['password'] = $_POST['password'];
    if (empty($values['email'])) {
        $errors['email'] = "Địa chỉ email là bắt buộc";
    }
    if ( ! empty($values['email'])
      && ! filter_var($values['email'], FILTER_VALIDATE_EMAIL)
    ) {
        $errors['email'] = "Địa chỉ email không hợp lệ";
    }
    if (empty($values['password'])) {
        $errors['password'] = "Mật khẩu là bắt buộc";
    }
    if ($errors == null) {
        // handle create user
        $hash = md5($values['password']);
        $tk   =$values['email'];
        $db = Database::getConnection();
        $db->begin_transaction();
        $stmt     = $db->prepare(" update ued.users set email='$tk',password='$hash' where id='$id' ");
       // $stmt->bind_param("ss", $values['email'], $hash);
        if ( ! $stmt->execute()) {
            if (endsWith($stmt->error, "'email_UNIQUE'")) {
                $message = array(
                  'type' => 'error', 'message' => "Địa chỉ email đã tồn tại",
                );
                $errors['email'] = 'Địa chỉ email đã tồn tại';
            }
        } else {
            $message = array(
              'type'    => 'success',
              'message' => "Tạo tài khoản quản trị ".$values['email']." thành công!",
            );
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
            <?php
            require_once "admin_menu.php"; ?>
            <div class="column is-9">
                <div class="columns">
                    <div class="column is-9">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-header-title">Cập nhật tài
                                    khoản quản trị viên
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
                                print path('/index.php?p=admin/users/edit&id='). $id; ?>">
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
                                                   print $values['email'] ?>"
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
                                        <label class="label">Mật khẩu</label>
                                        <div class="control">
                                            <input name="password"
                                                   class="input <?php
                                                   print ! empty($errors['password'])
                                                     ? 'is-danger' : ''; ?>"
                                                   type="password"
                                                   placeholder="Mật khẩu"
                                                   value="<?php
                                                   print ! empty($_POST['password'])
                                                     ? $_POST['password']
                                                     : ""; ?>"
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