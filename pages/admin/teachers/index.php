<?php
$teachers = array();
$message = null;
$db = Database::getConnection();
$stmt = $db->prepare("SELECT id, ho, ten, DATE_FORMAT(ngay_sinh, '%d/%m/%Y') ,email, dien_thoai FROM giang_vien ORDER BY id");

if (!$stmt->execute()) {
    $message = array('type' => 'error', 'message' => htmlspecialchars($stmt->error));
} else {
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $teachers[] = $row;
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
                        <div class="card-header-title">Danh sách giảng viên</div>
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
                                <th>Họ Tên</th>
                                <th>Ngày sinh</th>
                                <th>Email</th>
                                <th>Điện Thoại</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($teachers as $teacher): ?>
                                <tr>
                                    <td><?php print $teacher['id'] ?></td>
                                    <td><?php print $teacher['ho'] . " " . $teacher['ten'] ?></td>
                                    <td><?php print $teacher['ngay_sinh'] ?></td>
                                    <td><?php print $teacher['email'] ?></td>
                                    <td><?php print $teacher['dien_thoai'] ?></td>
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