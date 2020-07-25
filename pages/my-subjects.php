<?php
$rows = array();
$message = null;

$db = Database::getConnection();
$user = getCurrentUser();
if (empty($user)) {
    redirect('?p=login');
}
$userId = (int) $user['id'];
if ( ! empty($_POST) && ! empty($_POST['huy_dk'])) {
    // handle dk hoc phan
    $id = (int) $_POST['huy_dk'];
    $stmt
      = $db->prepare("DELETE FROM dang_ky WHERE user_id =? AND hoc_phan_id = ?");
    $stmt->bind_param("ii", $userId, $id);
    if ( ! $stmt->execute()) {
        $message = array('message' => $stmt->error, 'type' => 'error');
    } else {
        $message = array(
          'message' => "Huỷ đăng ký thành công", 'type' => 'success',
        );
    }
    $stmt->close();
}

$stmt = $db->prepare("SELECT hp.id,hp.ma_hoc_phan, hp.ten_hoc_phan, hp.so_tin_chi,hp.so_luong_toi_da, hp.thu,hp.tiet_bat_dau, hp.tiet_ket_thuc,gv.ten as ten_giang_vien, gv.ho as ho_giang_vien, dk.user_id as dk_user_id FROM hoc_phan AS hp  INNER JOIN giang_vien gv on hp.giang_vien_id = gv.id  INNER JOIN dang_ky AS dk ON dk.hoc_phan_id = hp.id AND dk.user_id = ?");
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
?>
<?php
require_once "header.php"; ?>
<div id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="card-header-title">Học phần đã đăng ký</div>
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
                <?php if(empty($rows)):?>
                <p>Bạn chưa đăng ký học phần nào.</p>
                <?php else:?>
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
                            <tr>
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
                                        <form method="post" action="<?php print currentUrl(); ?>"
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
                <?php endif;?>
            </div>
        </div>
    </div>
</div>