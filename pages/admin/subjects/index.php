<?php
$subjects = array();
$message = null;
$db = Database::getConnection();
// delete
if ( ! empty($_POST) && ! empty($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $s = $db->prepare("DELETE FROM mon_hoc WHERE id = ?");
    $s->bind_param("i",$delete_id);
    if ( ! $s->execute()) {
        $message = array('type' => 'success', 'message' => 'Lỗi xảy ra: '.$s->error);

    } else {
        $message = array('type'    => 'success',
                         'message' => 'Xoá thành công',
        );
    }
    $s->close();
}

// get
$stmt = $db->prepare("SELECT id, ten_mon_hoc FROM mon_hoc ORDER BY id");
if ( ! $stmt->execute()) {
    $message = array(
      'type'    => 'error',
      'message' => htmlspecialchars($stmt->error),
    );
} else {
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $subjects[] = $row;
    }
}
$stmt->close();
require_once "header.php";
?>
<div id="content">
    <div class="container">
        <div class="columns">
            <?php
            require_once "admin_menu.php"; ?>
            <div class="column is-10">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-title">Danh sách môn học</div>
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
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Môn học</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($subjects as $subject): ?>
                                <tr>
                                    <td><?php
                                        print $subject['id'] ?></td>
                                    <td><?php
                                        print $subject['ten_mon_hoc'] ?></td>
                                    <td>
                                        <div class="is-flex">
                                            <button class="button button is-text">
                                                <a href="<?php
                                                print path("?p=admin/subjects/edit&id=")
                                                  .$subject['id']; ?>">Sửa</a>
                                            </button>
                                            <form id="form-<?php
                                            print $subject['id']; ?>"
                                                  method="post" action="<?php
                                            print currentUrl(); ?>">
                                                <input name="delete_id"
                                                       type="hidden"
                                                       value="<?php
                                                       print $subject['id'] ?>">
                                                <button type="submit"
                                                        class="button is-text">
                                                    Xoá
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>