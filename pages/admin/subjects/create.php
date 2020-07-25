<?php
$values = array(
    'id' => "",
    'ten_mon_hoc' => "",
);
$errors = null;
$message = null;

function createSubject($values)
{
    $db = Database::getConnection();
    $stmt = $db->prepare("INSERT INTO mon_hoc (ten_mon_hoc) VALUES (?)");
    $stmt->bind_param("s",$values['ten_mon_hoc']);
    if (!$stmt->execute()) {
        return $stmt->error;
    }
    $stmt->close();
    return null;
}

if (!empty($_POST)) {
    $values['ten_mon_hoc'] = $_POST['ten_mon_hoc'];
    if (empty($values['ten_mon_hoc'])) {
        $errors['ten_mon_hoc'] = 'Bạn phải nhập vào tên môn học';
    }
    if($errors == NULL){
        $error = createSubject($values);
        if (!empty($error)) {
            $message = array('type' => 'error', 'message' => "Có lỗi xảy ra:" . $error);
        } else {
            $message = array('type' => 'success', 'message' => "Thêm thành công!");
        }
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
                                <div class="card-header-title">Thêm môn học</div>
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
                                <form method="post" action="<?php print currentUrl(); ?>">
                                    <div class="field">
                                        <label class="label">Tên môn học</label>
                                        <div class="control">
                                            <input value="<?php print $values['ten_mon_hoc']; ?>"
                                                   name="ten_mon_hoc" class="input"
                                                   type="text" placeholder="Tên môn học"
                                            >
                                            <?php if (!empty($errors['ten_mon_hoc'])): ?>
                                                <p class="help is-danger"><?php print $errors['ten_mon_hoc']; ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="control">
                                            <button type="submit" class="button is-link">Thêm môn học</button>
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