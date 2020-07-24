<?php

$subjects = array();
$message = null;
$db = Database::getConnection();
$stmt = $db->prepare(
  "SELECT hp.id, ten_hoc_phan, ma_hoc_phan, so_tin_chi, giang_vien_id, mon_hoc_id, so_luong_toi_da,thu,tiet_bat_dau, tiet_ket_thuc, gv.ho,gv.ten, mh.ten_mon_hoc FROM hoc_phan AS hp INNER JOIN giang_vien as gv ON gv.id = hp.giang_vien_id INNER JOIN mon_hoc as mh ON mh.id = hp.mon_hoc_id ORDER BY id DESC"
);
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
                        <div class="card-header-title">Học phần đang mở</div>
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
                                <th>Mã học phần</th>
                                <th>Tên học phần</th>
                                <th>Số tín chỉ</th>
                                <th>Số lượng tối đa</th>
                                <th>Giảng viên</th>
                                <th>Nhóm môn học</th>
                                <th>Thứ</th>
                                <th>Tiết</th>
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
                                        print $subject['ma_hoc_phan'] ?></td>
                                    <td><?php
                                        print $subject['ten_hoc_phan'] ?></td>
                                    <td><?php
                                        print $subject['so_tin_chi'] ?></td>
                                    <td><?php
                                        print $subject['so_luong_toi_da'] ?></td>
                                    <td><?php
                                        print $subject['ho']." "
                                          .$subject['ten']; ?></td>
                                    <td><?php
                                        print $subject['ten_mon_hoc']; ?></td>
                                    <td><?php
                                        print 'Thứ '.$subject['thu'] ?> </td>
                                    <td><?php
                                        print 'Tiết '
                                            .$subject['tiet_bat_dau']."-"
                                            .$subject['tiet_ket_thuc']; ?></td>
                                    <td>
                                        <span><a href="<?php print path("?p=admin/open-subjects/edit&id=") . $subject['id'];?>">Sửa</a></span>
                                        <span><a href="<?php print path("?p=admin/open-subjects/delete&id=") . $subject['id'];?>">Xoá</a></span>
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