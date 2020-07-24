<?php

if (empty($_GET['id'])) {
    redirect('?p=notfound');
}
$values = array(
    'id'          => "",
    'ten_mon_hoc' => "",
);
$errors = null;
$message = null;

function getSubject($id)
{
    $id = (int) $id;
    $db = Database::getConnection();

    return $db->query("SELECT id, ten_mon_hoc FROM mon_hoc WHERE id = $id")
        ->fetch_assoc();
}

function editSubject($values)
{
    $db = Database::getConnection();
    $stmt = $db->prepare("DELETE FROM mon_hoc WHERE id = ?");
    $stmt->bind_param("si", $values['ten_mon_hoc'], $values['id']);
    if ( ! $stmt->execute()) {
        return $stmt->error;
    }
    $stmt->close();

    return null;
}

if ( ! empty($_POST)) {
    $values['id'] = $_POST['id'];
    $values['ten_mon_hoc'] = $_POST['ten_mon_hoc'];
    if (empty($values['id'])) {
        $errors['id'] = 'Bạn phải nhập vào Mã môn học';
    }
    if (empty($values['ten_mon_hoc'])) {
        $errors['ten_mon_hoc'] = 'Bạn phải nhập vào Tên môn học';
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
$values['ten_mon_hoc'] = $subject['ten_mon_hoc'];
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
                                print path('/index.php?p=admin/subjects/edit&id='
                                    .$id); ?>">
                                    <div class="field">
                                        <input value="<?php
                                        print $values['id']; ?>"
                                               name="id" class="input"
                                               type="hidden"
                                        >
                                    </div>
                                    <div class="field">
                                        <label class="label">Tên môn học</label>
                                        <div class="control">
                                            <input value="<?php
                                            print $values['ten_mon_hoc']; ?>"
                                                   name="ten_mon_hoc"
                                                   class="input"
                                                   type="text"
                                                   placeholder="Tên môn học"
                                            >
                                            <?php
                                            if ( ! empty($errors['ten_mon_hoc'])): ?>
                                                <p class="help is-danger"><?php
                                                    print $errors['ten_mon_hoc']; ?></p>
                                            <?php
                                            endif; ?>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="control">
                                            <button type="submit"
                                                    class="button is-link">Câp
                                                nhật môn học
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