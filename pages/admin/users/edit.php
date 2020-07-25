<?php

if (empty($_GET['id'])) {
    redirect('?p=notfound');
}
$values = array(
  'id'          => "",
  'email' => "",
  'password' => "",
);
$errors = null;
$message = null;

function getSubject($id)
{
    $id = (int) $id;
    $db = Database::getConnection();

    return $db->query("SELECT id, email FROM users WHERE id = $id")
      ->fetch_assoc();
}

function editSubject($values)
{
    $db = Database::getConnection();
    $hash =md5($values['password']);
    $stmt = $db->prepare("UPDATE users SET email =? ,password =? WHERE id = ?");
    $stmt->bind_param("ssi", $values['email'], $hash,$values['id']);
    if ( ! $stmt->execute()) {
        return $stmt->error;
    }
    $stmt->close();

    return null;
}

if ( ! empty($_POST)) {
    $values['id'] = $_POST['id'];
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
$values['email'] = $subject['email'];

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
                                <div class="card-header-title">Cập nhật môn
                                    học
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
                                print path('/index.php?p=admin/users/edit&id='
                                  .$id); ?>">
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
                                         <label class="label">Mật Khẩu Mới</label>
                                         <div class="control">
                                             <input
                                                    name="password"
                                                    class="input"
                                                    type="password"
                                                    placeholder="New Password"
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
                                                    class="button is-link">Cập Nhập

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