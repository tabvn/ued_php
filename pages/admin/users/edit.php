<?php
if (empty($_GET['id'])) {
    redirect('?p=notfound');
}
$values = array(
  'id'       => "",
  'email'    => "",
  'password' => "",
);
$errors = null;
$message = null;

function getUser($id)
{
    $id = (int) $id;
    $db = Database::getConnection();

    return $db->query("SELECT id, email FROM users WHERE id = $id")
      ->fetch_assoc();
}

function editUser($values)
{
    $db = Database::getConnection();
    $hash = md5($values['password']);
    $sql = "UPDATE users set email = ?";
    if ( ! empty($values['password'])) {
        $sql = "UPDATE users SET email = ?, password = ?";
    }
    $sql .= " WHERE id = ?";
    $stmt = $db->prepare($sql);
    if ( ! empty($values['password'])) {
        $stmt->bind_param("ssi", $values['email'], $hash, $values['id']);
    } else {
        $stmt->bind_param("si", $values['email'], $values['id']);
    }
    if ( ! $stmt->execute()) {
        return $stmt->error;
    }
    $stmt->close();

    return null;
}

if ( ! empty($_POST)) {
    $values['id'] = (int)$_POST['id'];
    $values['email'] = $_POST['email'];
    $values['password'] = $_POST['password'];
    if (empty($values['email'])) {
        $errors['email'] = 'Bạn phải nhập vào Email';
    }
    if ($errors == null) {
        $error = editUser($values);
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
$user = getUser($id);
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
            <?php
            require_once "admin_menu.php"; ?>
            <div class="column is-9">
                <div class="columns">
                    <div class="column is-9">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-header-title">Câp nhật thông tin quản trị viên
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
                                print currentUrl(); ?>">
                                    <div class="field">
                                        <input value="<?php
                                        print $values['id']; ?>"
                                               name="id" class="input"
                                               type="hidden"
                                        >
                                    </div>
                                    <div class="field">
                                        <label class="label">Email</label>
                                        <div class="control">
                                            <input value="<?php
                                            print $values['email']; ?>"
                                                   name="email"
                                                   class="input"
                                                   type="text"
                                                   placeholder="Email"
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
                                        <label class="label">Mật Khẩu
                                            Mới</label>
                                        <div class="control">
                                            <input
                                                    value="<?php print !empty($_POST['password']) ? $_POST['password'] : '';?>"
                                                    name="password"
                                                    class="input"
                                                    type="password"
                                                    placeholder="Mật khẩu mới"
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
                                        <div class="control">
                                            <button type="submit"
                                                    class="button is-link">Cập
                                                Nhập
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