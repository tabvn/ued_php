<?php
$teachers = array();
$message = null;
$db = Database::getConnection();
// delete
if(!empty($_POST) && !empty($_POST['delete_id'])){
    $delete_id = $_POST['delete_id'];
    $s = $db->prepare("DELETE FROM giang_vien WHERE id = ?");
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
$stmt = $db->prepare("SELECT id, ho, ten, DATE_FORMAT(ngay_sinh, '%d/%m/%Y') AS ngay_sinh ,email, dien_thoai FROM giang_vien ORDER BY id");
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
                                <th></th>
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
                                    <td>
                                        <div class="is-flex">
                                            <button type="button" class="button is-text">Sửa</button>
                                            <form id="form-<?php print $teacher['id']?>" action="<?php print currentUrl();?>" method="post">
                                                <input name="delete_id" type="hidden" value="<?php print $teacher['id'];?>">
                                                <button type="submit" class="button is-text">Xoá</button>
                                            </form>
                                        </div>
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