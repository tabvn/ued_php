<?php

$db = Database::getConnection();
$user = getCurrentUser();
if (empty($user)) {
    redirect('?p=login');
}
$userId = (int) $user['id'];
if ( ! empty($_POST) && ! empty($_POST['dk'])) {
    var_dump($_POST);
}
$rows = array();
$message = null;
$stmt
  = $db->prepare("SELECT hp.id,hp.ma_hoc_phan, hp.ten_hoc_phan, hp.so_tin_chi,hp.so_luong_toi_da, hp.thu,hp.tiet_bat_dau, hp.tiet_ket_thuc,gv.ten as ten_giang_vien, gv.ho as ho_giang_vien, dk.user_id as dk_user_id FROM hoc_phan AS hp INNER JOIN giang_vien gv on hp.giang_vien_id = gv.id  LEFT JOIN dang_ky AS dk ON dk.hoc_phan_id = hp.id AND dk.user_id = ?");
$stmt->bind_param("i", $user['id']);
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
var_dump($rows);
?>
<?php
require_once "header.php"; ?>
<div id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="card-header-title">Học phần đang mở</div>
            </div>
            <div class="card-content">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Thời khoá biểu</th>
                        <th>Mã học phần</th>
                        <th>Tên học phần</th>
                        <th>Số tín chỉ</th>
                        <th>Số lượng tối đa</th>
                        <th>Giảng viên</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($rows as $row): ?>
                        <?php
                        $selected = 'not-select';
                        if ( ! empty($row['dk_user_id'])) {
                            $selected = 'is-selected';
                        }
                        ?>
                        <tr class="<?php
                        print $selected; ?>">
                            <td>
                                Thứ <?php
                                print $row['thu'].', tiết: '
                                  .$row['tiet_bat_dau'].'-'
                                  .$row['tiet_ket_thuc']; ?>
                            </td>
                            <td>
                                <?php
                                print $row['ma_hoc_phan']; ?>
                            </td>
                            <td>
                                <?php
                                print $row['ten_hoc_phan']; ?>
                            </td>
                            <td>
                                <?php
                                print $row['so_tin_chi']; ?>
                            </td>
                            <td>
                                <?php
                                print $row['so_luong_toi_da']; ?>
                            </td>
                            <td>
                                <?php
                                print $row['ten_giang_vien'].' '
                                  .$row['ho_giang_vien']; ?>
                            </td>
                            <td>
                                <?php
                                if (empty($row['dk_user_id'])): ?>
                                    <form method="post" action="<?php
                                    print path('?p=subjects') ?>"
                                          id="form-dk-<?php
                                          print $row['id'] ?>">
                                        <input name="dk" type="hidden"
                                               value="<?php
                                               print $row['id'] ?>">
                                        <button type="submit">Đăng ký</button>
                                    </form>
                                <?
                                else : ?>
                                    <form method="post" action="<?php
                                    print path('?p=subjects') ?>"
                                          id="form-dk-<?php
                                          print $row['id'] ?>">
                                        <input name="huy_dk" type="hidden"
                                               value="<?php
                                               print $row['id'] ?>">
                                        <button type="submit">Huỷ đăng ký
                                        </button>
                                    </form>
                                <?php
                                endif; ?>
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