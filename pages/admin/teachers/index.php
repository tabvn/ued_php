<?php
$teachers = array();
$message = null;
$db = Database::getConnection();
$stmt = $db->prepare("SELECT id, ho, ten, ngay_sinh FROM giang_vien ORDER BY id");
if (!$stmt->execute()) {
    $message = array('type' => 'error', 'message' => htmlspecialchars($stmt->error));
} else {
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $result = array(
            'id' => NULL,
            'ho' => NULL,
            'ten' => NULL,
            'ngay_sinh' => NULL,
        );
        $stmt->bind_result(
            $result['id'],
            $result['ho'],
            $result['ten'],
            $result['ngay_sinh']
        );
        if ($stmt->num_rows > 0) {
            while ($stmt->fetch()) {
                $teachers[] = array(
                    'id' => $result['id'],
                    'ho' => $result['ho'],
                    'ten' => $result['ten'],
                    'ngay_sinh' => $result['ngay_sinh'],
                );
            }
        }
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
                                <th>Mã giảng viên</th>
                                <th>Họ Tên</th>
                                <th>Ngày sinh</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($teachers as $teacher): ?>
                                <tr>
                                    <td><?php print $teacher['id'] ?></td>
                                    <td><?php print $teacher['ho'] . " " . $teacher['ten'] ?></td>
                                    <td><?php print $teacher['ngay_sinh'] ?></td>
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