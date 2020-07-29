<?php
$rows = array();
$message = null;
$db = Database::getConnection();
// DELETE
if(!empty($_POST) && !empty($_POST['delete_id'])){
    $id = (int) $_POST['delete_id'];
    $q = $db->prepare("DELETE FROM users WHERE id = ?");
    $q->bind_param("i", $id);
    if ( ! $q->execute()) {
        $message = array(
          'type'    => 'error',
          'message' => "Có lỗi xảy ra: ".htmlspecialchars($q->error),
        );
    } else {
        $message = array(
          'type' => 'success', 'message' => "Xoá thành công",
        );
    }
}
//GET
$stmt = $db->prepare("SELECT id, email from users WHERE role = 'admin'");
if ( ! $stmt->execute()) {
    $message = array(
      'type' => 'error', 'message' => htmlspecialchars($stmt->error),
    );
} else {
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
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
                        <div class="card-header-title">Tất cả quản trị viên
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
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($rows as $row): ?>
                                <tr>
                                    <td><?php
                                        print $row['id'] ?></td>
                                    <td><?php
                                        print $row['email'] ?></td>
                                    <td>
                                        <div class="is-flex">
                                            <a  href="<?php
                                            print path("?p=admin/users/edit&id=")
                                              .$row['id'];?>" class="button is-text">Sửa</a>
                                            <form action="<?php print currentUrl();?>" method="post" id="form-<?php print $row['id'];?>">
                                                <input name="delete_id" value="<?php print $row['id']?>" type="hidden">
                                                <button type="submit" class="button is-text">Xoá</button>
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