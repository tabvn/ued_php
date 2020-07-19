<?php

$values = array(
    'id' => '',
    'ten_hoc_phan' => '',
    'ma_hoc_phan' => "",
    'so_tin_chi' => "",
    'so_luong_toi_da' => "",
    'thu' => "",
    'tiet_bat_dau' => "",
    'tiet_ket_thuc' => "",
);
$errors = array();
$message = array();


function getTeachers()
{
    $teachers = array();
    $db = Database::getConnection();
    $stmt = $db->prepare("SELECT id,ho,ten FROM giang_vien");
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

    return $teachers;
}

function getSubjects()
{
    $items = array();
    $db = Database::getConnection();
    $stmt = $db->prepare("SELECT id,ten_mon_hoc FROM mon_hoc");
    if ( ! $stmt->execute()) {
        $message = array(
          'type' => 'error', 'message' => htmlspecialchars($stmt->error),
        );
    } else {
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
    }
    $stmt->close();
    return $items;
}

function isOverlapSubject($thu, $from, $to)
{
    $db = Database::getConnection();
    $from = (int) $from;
    $to = (int) $to;
    $thu = (int) $thu;
    $result
      = $db->query("SELECT COUNT(id) as total FROM hoc_phan WHERE thu = $thu AND ($from <= tiet_ket_thuc AND $to >= tiet_bat_dau)")
      ->fetch_assoc();
    if ($result['total'] > 0) {
        return true;
    }

    return false;
}

function createOpenSubject($giangvienId, $monhocId, $values)
{
    $db = Database::getConnection();
  $stmt = $db->prepare("INSERT INTO hoc_phan (ten_hoc_phan, ma_hoc_phan, so_tin_chi, so_luong_toi_da, thu, tiet_bat_dau, tiet_ket_thuc, giang_vien_id, mon_hoc_id,) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssiisiiii", $values['ten_hoc_phan'], $values['ma_hoc_phan'], $values['so_tin_chi'], $values['so_luong_toi_da'], $values['thu'], $values['tiet_bat_dau'], $values['tiet_ket_thuc'], $giangvienId, $monhocId);

    if (!$stmt->execute()) {
    return $stmt->error;
  }
  $stmt->close();
  return null;
}

if ( ! empty($_POST)) {
    $values['ma_hoc_phan'] = $_POST['ma_hoc_phan'];
    $values['ten_hoc_phan'] = $_POST['ten_hoc_phan'];
    $values['so_tin_chi'] = $_POST['so_tin_chi'];
    $values['so_luong_toi_da'] = $_POST['so_luong_toi_da'];
    if (empty($values['ma_hoc_phan'])) {
        $errors['ma_hoc_phan'] = 'Mã học phần là bắt buộc!';
    }
    if (empty($values['ten_hoc_phan'])) {
        $errors['ten_hoc_phan'] = 'Tên học phần là bắt buộc!';
    }
    if (empty($values['so_tin_chi'])) {
        $errors['so_tin_chi'] = 'Số tín chỉ là bắt buộc!';
    }
    if (empty($values['so_luong_toi_da'])) {
        $errors['so_luong_toi_da'] = 'Số tín chỉ là bắt buộc!';
    }
    if ($errors == null || empty($values)) {
        $error = createOpenSubject($db->insert_id, $db->insert_id, $values);
        if ( ! empty($error)) {
            $message = array(
              'type' => 'error', 'message' => "Có lỗi xảy ra:".$error,
            );
        } else {
            $message = array(
              'type' => 'success', 'message' => "Thêm thành công!",
            );
        }
    }
}
require_once "header.php";
function getValue($name)
{
    if ( ! empty($_POST)) {
        if (isset($_POST[$name])) {
            return $_POST[$name];
        }
    }

    return "";
}

function input($options, $error)
{
    if ( ! isset($options['placeholder'])) {
        $options['placeholder'] = "";
    }
    if ( ! isset($options['type'])) {
        $options['type'] = "text";
    }
    $class = "input";
    if ( ! empty($error)) {
        $class .= ' is-danger';
    }
    if ( ! isset($options['value'])) {
        if ( ! empty($_POST)) {
            if ( ! empty($_POST[$options['name']])) {
                $options['value'] = $_POST[$options['name']];
            }
        }
        $options['value'] = '';
    }
    $html = "<div class=\"field\">";
    $html .= "<label class=\"label\">".$options['label']."</label>";
    $html .= "<div class=\"control\">";
    $html .= '<input value="'.$options['value'].'" class="'.$class.'" type="'
      .$options['type'].'" name="'.$options['name'].'" placeholder="'
      .$options['placeholder'].'" />';
    if ( ! empty($error)) {
        $html .= '<p class="help is-danger">'.$error.'</p>';
    }
    $html .= "</div>";
    $html .= "</div>";

    return $html;
}

$teachers = getTeachers();
$subjects = getSubjects()
?>
<div id="content">
    <div class="container">
        <div class="columns">
            <?php
            require_once "admin_menu.php"; ?>
            <div class="column is-9">
                <div class="columns">
                    <div class="column is-9">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-header-title">Thêm học phần
                                </div>
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
                                <form method="post"
                                      action="<?php
                                      print path('/index.php?p=admin/open-subjects/create'); ?>">
                                    <?php
                                    print input(array(
                                      'label' => 'Tên học phần',
                                      'name'  => 'ten_hoc_phan',
                                    ), ! empty($errors['ten_hoc_phan'])
                                      ? $errors['ten_hoc_phan'] : null);
                                    ?>
                                    <?php
                                    print input(array(
                                      'label' => 'Mã học phần',
                                      'name'  => 'ma_hoc_phan',
                                    ), ! empty($errors['ma_hoc_phan'])
                                      ? $errors['ma_hoc_phan'] : null);
                                    ?>

                                    <?php
                                    print input(array(
                                      'label' => 'Số tín chỉ',
                                      'name'  => 'so_tin_chi',
                                    ), ! empty($errors['so_tin_chi'])
                                      ? $errors['so_tin_chi'] : null);
                                    ?>
                                    <div class="field">
                                        <label class="label">Giảng viên</label>
                                        <div class="control">
                                            <div class="select">
                                                <select name="giang_vien_id">
                                                    <?php
                                                    foreach (
                                                      $teachers as $teacher
                                                    ): ?>
                                                        <option value="<?php
                                                        print $teacher['d']; ?>"><?php
                                                            print $teacher['ho']
                                                              ." "
                                                              .$teacher['ten']; ?></option>
                                                    <?php
                                                    endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label class="label">Môn học</label>
                                        <div class="control">
                                            <div class="select">
                                                <select name="mon_hoc_id">
                                                    <?php
                                                    foreach (
                                                      $subjects as $subject
                                                    ): ?>
                                                        <option value="<?php
                                                        print $subject['id']; ?>"><?php
                                                            print $subject['ten_mon_hoc']; ?></option>
                                                    <?php
                                                    endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    print input(array(
                                      'label' => 'Số lượng tối đa',
                                      'name'  => 'so_luong_toi_da',
                                    ), ! empty($errors['so_luong_toi_da'])
                                      ? $errors['so_luong_toi_da'] : null);
                                    ?>
                                    <div class="field">
                                        <label class="label">Thứ</label>
                                        <div class="control">
                                            <div class="select">
                                                <select name="thu">
                                                    <option value="2">Thứ 2</option>
                                                    <option value="3">Thứ 3</option>
                                                    <option value="4">Thứ 4</option>
                                                    <option value="5">Thứ 5</option>
                                                    <option value="6">Thứ 6</option>
                                                    <option value="7">Thứ 7</option>
                                                    <option value="cn">Chủ nhật</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label class="label">Tiết bắt đầu</label>
                                        <div class="control">
                                            <select name="tiet_bat_dau">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <label class="label">Tiết kết thúc</label>
                                        <div class="control">
                                            <select name="tiet_ket_thuc">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="control">
                                            <button type="submit"
                                                    class="button is-link">Thêm học phần
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>