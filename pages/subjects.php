<?php

function getSubject($id)
{
    $id = (int) $id;
    $db = Database::getConnection();

    return $db->query("SELECT id, thu,tiet_bat_dau, tiet_ket_thuc FROM hoc_phan WHERE id = $id")
      ->fetch_assoc();
}

function isOverlapSubject($userId, $thu, $from, $to)
{
    $db = Database::getConnection();
    $userId = (int) $userId;
    $from = (int) $from;
    $to = (int) $to;
    $thu = (int) $thu;
    $result
      = $db->query("SELECT COUNT(id) as total FROM hoc_phan AS hp INNER JOIN dang_ky as dk on dk.hoc_phan_id = hp.id AND dk.user_id = $userId WHERE thu = $thu AND ($from <= tiet_ket_thuc AND $to >= tiet_bat_dau)")
      ->fetch_assoc();
    if ($result['total'] > 0) {
        return true;
    }

    return false;
}

$rows = array();
$message = null;

$db = Database::getConnection();
$user = getCurrentUser();
if (empty($user)) {
    redirect('?p=login');
}
$userId = (int) $user['id'];
if ( ! empty($_POST) && ! empty($_POST['dk'])) {
    // handle dk hoc phan
    $id = (int) $_POST['dk'];
    $subject = getSubject($id);
    if (empty($subject)) {
        redirect('?p=notfound');
    }
    if (isOverlapSubject($userId, $subject['thu'], $subject['tiet_bat_dau'],
      $subject['tiet_ket_thuc'])
    ) {
        $message = array(
          'type'    => 'error',
          'message' => 'Đăng ký không thành công lý do: trùng lịch học',
        );
    } else {
        // dk now
        $stmt
          = $db->prepare("INSERT INTO dang_ky (hoc_phan_id, user_id) VALUES (?,?)");
        $stmt->bind_param("ii", $subject['id'], $userId);
        if ( ! $stmt->execute()) {
            $message = array('message' => $stmt->error, 'type' => 'error');
        } else {
            $message = array(
              'message' => "Đăng ký thành công", 'type' => 'success',
            );
        }
        $stmt->close();
    }
}

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