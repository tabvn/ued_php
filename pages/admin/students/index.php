<?php
$students = array();
$message = null;
$db = Database::getConnection();
// delete
if ( ! empty($_POST) && ! empty($_POST['delete_id'])) {
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
// get
$stmt
  = $db->prepare("SELECT u.id,u.email, sv.id as svid,sv.ma_sinh_vien, sv.ten, sv.ho, DATE_FORMAT(sv.ngay_sinh, '%d/%m/%Y') as ngay_sinh, sv.lop FROM sinh_vien as sv INNER JOIN users as u ON u.id = sv.user_id order by u.id asc LIMIT 0,10");
//$stmt->bind_param("i", 10);
if ( ! $stmt->execute()) {
    $message = array(
      'type' => 'error', 'message' => htmlspecialchars($stmt->error),
    );
} else {
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
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
                        <div class="card-header-title">Danh sách sinh viên</div>
                        <a href="<?php print path('?p=admin/students/create');?>"><button class="button is-small is-primary">Thêm sinh viên</button></a>
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
                                <th>Mã sinh viên</th>
                                <th>Họ Tên</th>
                                <th>Email</th>
                                <th>Ngày sinh</th>
                                <th>Lớp</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($students as $student): ?>
                                <tr>
                                    <td><?php
                                        print $student['ma_sinh_vien'] ?></td>
                                    <td><?php
                                        print $student['ho']." "
                                          .$student['ten'] ?></td>
                                    <td><?php
                                        print $student['email'] ?></td>
                                    <td><?php
                                        print $student['ngay_sinh'] ?></td>
                                    <td><?php
                                        print $student['lop'] ?></td>
                                    <td>
                                        <div class="is-flex">
                                            <button class="button is-text"><a
                                                        href="<?php
                                                        print path("?p=admin/students/edit&id=")
                                                          .$student['svid']; ?>">Sửa</a>
                                            </button>
                                            <form method="post" action="<?php
                                            print currentUrl(); ?>"
                                                  id="form-<?php
                                                  print $student['id'] ?>">
                                                <input name="delete_id"
                                                       value="<?php
                                                       print $student['id'] ?>"
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