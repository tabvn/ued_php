<?php

function getTotal($id)
{
    if ($id == 0) {
        return 0;
    }
    $result = Database::getConnection()
      ->query("SELECT COUNT(*) AS total FROM dang_ky WHERE hoc_phan_id =$id")
      ->fetch_assoc();

    return $result['total'];
}

function getSubject($id)
{
    if ($id == 0) {
        return null;
    }

    return Database::getConnection()
      ->query("SELECT hp.ten_hoc_phan,hp.ma_hoc_phan,hp.so_luong_toi_da, gv.ten, gv.ho FROM hoc_phan as hp INNER JOIN giang_vien gv on hp.giang_vien_id = gv.id  WHERE hp.id = $id")
      ->fetch_assoc();
}

function getSubjects()
{
    $db = Database::getConnection();

    return $db->query("SELECT id,ten_hoc_phan,ma_hoc_phan FROM hoc_phan")->fetch_all();
}

$rows = array();
$message = null;
$db = Database::getConnection();
// GET
$hp_id = ! empty($_GET['id']) ? (int) $_GET['id'] : 0;
$stmt = $db->prepare(
  "SELECT u.id,u.email,sv.ma_sinh_vien, sv.ho,sv.ten,DATE_FORMAT(sv.ngay_sinh, '%d/%m/%Y') as ngay_sinh, DATE_FORMAT(dk.thoi_gian, '%d/%m/%Y %h:%i:%s %p') as thoi_gian, sv.lop FROM users as u INNER JOIN  sinh_vien sv on u.id = sv.user_id INNER JOIN dang_ky dk on u.id = dk.user_id AND dk.hoc_phan_id = ? order by dk.thoi_gian ASC"
);
$stmt->bind_param("i", $hp_id);
if ( ! $stmt->execute()) {
    $message = array(
      'type'    => 'error',
      'message' => htmlspecialchars($stmt->error),
    );
} else {
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
}
$stmt->close();
$hp = getSubject($hp_id);
$allSubjects = getSubjects();
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
                        <div class="card-header-title">
                            <div class="is-flex">
                                Danh sách đăng ký
                            </div>

                        </div>
                    </div>
                    <div class="card-content">
                        <div class="field">
                            <div class="control">
                                <div class="select">
                                    <select onchange="handleOnSelectChange('<?php
                                    print path('?p=admin/open-subjects/registered&id=') ?>', this.value);">
                                        <option value="0">Chọn học phần</option>
                                        <?php
                                        foreach ($allSubjects as $subject):
                                            $selected = "";
                                            if ($subject[0] == $hp_id) {
                                                $selected = " selected";
                                            }
                                            ?>
                                            <option value="<?php
                                            print $subject[0]; ?>"<?php
                                            print $selected; ?>><?php
                                                print $subject[1]. ' ('.$subject[2].')'; ?></option>
                                        <?php
                                        endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
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

                        <?php
                        if ( ! empty($hp)): ?>
                            <div class="box">
                                <p>Tên học phần: <span class="tag is-light"><?
                                        print $hp['ten_hoc_phan']; ?></span></p>
                                <p>Mã học phần: <span class="tag is-light"><?
                                        print $hp['ma_hoc_phan']; ?></span></p>
                                <p>Giảng viên: <span class="tag is-light"><?
                                        print $hp['ho'].' '
                                          .$hp['ten']; ?></span>
                                </p>
                                <p>Số lượng đăng ký: <span class="tag is-light"><?
                                        print getTotal($hp_id); ?>/<?php print $hp['so_luong_toi_da']?></span></p>
                            </div>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Mã sinh viên</th>
                                    <th>Sinh viên</th>
                                    <th>Ngày sinh</th>
                                    <th>Lớp</th>
                                    <th>Thời gian đăng ký</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($rows as $row): ?>
                                    <tr>
                                        <td><?php
                                            print $row['ma_sinh_vien']; ?></td>
                                        <td><?php
                                            print $row['ho']." "
                                              .$row['ten']; ?></td>
                                        <td><?php
                                            print $row['ngay_sinh']; ?></td>
                                        <td><?php
                                            print $row['lop']; ?></td>
                                        <td><?php
                                            print $row['thoi_gian']; ?></td>
                                    </tr>
                                <?php
                                endforeach; ?>
                                </tbody>
                            </table>
                        <?php
                        endif; ?>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>