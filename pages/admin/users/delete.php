<?php

if (empty($_GET['id'])) {
    redirect('?p=notfound');
}
$values = array(
  'id'          => "",
  'email' => "",

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

    $stmt = $db->prepare("DELETE from users where id = ? limit 1");
    $stmt->bind_param("i",$values['id']);
    if ( ! $stmt->execute()) {
        return $stmt->error;
    }
    $stmt->close();

    return null;
}

if ( ! empty($_POST)) {
    $values['id'] = $_POST['id'];

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
                                <div class="card-header-title">Xóa Quản Trị Viên

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
                                print path('/index.php?p=admin/users/delete&id='
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
                                                   type="button"
                                                   placeholder="Email"
                                            >

                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="control">
                                            <button type="submit"
                                                    class="button is-link">Xóa

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