<?php
$rows = array();
$message = null;
$db = Database::getConnection();
$stmt = $db->prepare("SELECT id, email from users WHERE role = 'admin'");
//$stmt->bind_param("i", 10);
if (!$stmt->execute()) {
    $message = array('type' => 'error', 'message' => htmlspecialchars($stmt->error));
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
            <?php require_once "admin_menu.php"; ?>
            <div class="column is-10">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-title">Tất cả quản trị viên</div>
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
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($rows as $row): ?>
                                <tr>
                                    <td><?php print $row['id'] ?></td>
                                    <td><?php print $row['email'] ?></td>
                                    <td>
                                        <span><a href="<?php print path("?p=admin/users/edit&id=") . $row['id'];?>">Sửa</a></span>
                                        <span><a href="<?php print path("?p=admin/users/delete&id=") . $row['id'];?>">Xoá</a></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>