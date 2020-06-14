<?php
$students = array();
$message = null;
$db = Database::getConnection();
$stmt = $db->prepare("SELECT u.email, sv.ma_sinh_vien, sv.ten, sv.ho, DATE_FORMAT(sv.ngay_sinh, '%d/%m/%Y'), sv.lop FROM sinh_vien as sv INNER JOIN users as u ON u.id = sv.user_id order by u.id asc LIMIT 0,10");
//$stmt->bind_param("i", 10);
if (!$stmt->execute()) {
    $message = array('type' => 'error', 'message' => htmlspecialchars($stmt->error));
} else {
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $result = array(
            'email' => NULL,
            'ma_sinh_vien' => NULL,
            'ten' => NULL,
            'ho' => NULL,
            'ngay_sinh' => NULL,
            'lop' => NULL,
        );
        $stmt->bind_result(
            $result['email'],
            $result['ma_sinh_vien'],
            $result['ten'],
            $result['ho'],
            $result['ngay_sinh'],
            $result['lop']
        );
        if ($stmt->num_rows > 0) {
            while ($stmt->fetch()) {
                $students[] = array(
                    'email' => $result['email'],
                    'ma_sinh_vien' => $result['ma_sinh_vien'],
                    'ten' => $result['ten'],
                    'ho' => $result['ho'],
                    'ngay_sinh' => $result['ngay_sinh'],
                    'lop' => $result['lop'],
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
                        <div class="card-header-title">Danh sách sinh viên</div>
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
                                <th>Mã sinh viên</th>
                                <th>Họ Tên</th>
                                <th>Email</th>
                                <th>Ngày sinh</th>
                                <th>Lớp</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($students as $student): ?>
                                <tr>
                                    <td><?php print $student['ma_sinh_vien'] ?></td>
                                    <td><?php print $student['ho'] . " " . $student['ten'] ?></td>
                                    <td><?php print $student['email'] ?></td>
                                    <td><?php print $student['ngay_sinh'] ?></td>
                                    <td><?php print $student['lop'] ?></td>
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