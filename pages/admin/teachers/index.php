<?php

$teachers = array();
$message = null;
$db = Database::getConnection();
// delete
if ( ! empty($_POST) && ! empty($_POST['delete_id'])) {
    $id = (int) $_POST['delete_id'];
    $q = $db->prepare("DELETE FROM giang_vien WHERE id = ?");
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
// get
$stmt
    = $db->prepare("SELECT id, ho, ten, DATE_FORMAT(ngay_sinh, '%d/%m/%Y') as ngay_sinh, email, dien_thoai FROM giang_vien order by id asc LIMIT 0,10");
//$stmt->bind_param("i", 10);
if ( ! $stmt->execute()) {
    $message = array(
        'type' => 'error', 'message' => htmlspecialchars($stmt->error),
    );
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
            <?php
            require_once "admin_menu.php"; ?>
            <div class="column is-10">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-title">Danh sách giảng viên</div>
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
                                <th>Họ tên</th>
                                <th>Ngày sinh</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($teachers as $teacher): ?>
                                <tr>
                                    <td><?php
                                        print $teacher['id'] ?></td>
                                    <td><?php
                                        print $teacher['ho']." "
                                            .$teacher['ten'] ?></td>
                                    <td><?php
                                        print $teacher['ngay_sinh'] ?></td>
                                    <td><?php
                                        print $teacher['email'] ?></td>
                                    <td><?php
                                        print $teacher['dien_thoai'] ?></td>
                                    <td>
                                        <div class="is-flex">
                                            <button class="button is-text"><a
                                                        href="<?php
                                                        print path("?p=admin/teachers/edit&id=")
                                                            .$teacher['id']; ?>">Sửa</a>
                                            </button>
                                            <form method="post" action="<?php
                                            print currentUrl(); ?>"
                                                  id="form-<?php
                                                  print $teacher['id'] ?>">
                                                <input name="delete_id"
                                                       value="<?php
                                                       print $teacher['id'] ?>"
                                                       type="hidden">
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