<?php
$values = array();
$errors = array();
$message = array();


function getTeachers()
{
	$teachers = array();
	$db = Database::getConnection();
	$stmt = $db->prepare("SELECT id,ho,ten FROM giang_vien");
	if (!$stmt->execute()) {
		$message = array('type' => 'error', 'message' => htmlspecialchars($stmt->error));
	} else {
		$result = $stmt->get_result();
		while ($row = $result->fetch_assoc()) {
			$teachers[] = $row;
		}
	}
	$stmt->close();

	return $teachers;
}

function createOpenSubject($values)
{
	/*$db = Database::getConnection();
	$stmt = $db->prepare("INSERT INTO mon_hoc (id, ten_mon_hoc) VALUES (?, ?)");
	$stmt->bind_param("is", $values['id'], $values['ten_mon_hoc']);
	if (!$stmt->execute()) {
		return $stmt->error;
	}
	$stmt->close();
	return null;*/
}

if (!empty($_POST)) {
	$values['ma_hoc_phan'] = $_POST['ma_hoc_phan'];
	if (empty($values['ma_hoc_phan'])) {
		$errors['ma_hoc_phan'] = 'Mã học phần là bắt buộc!';
	}
	if ($errors == NULL || empty($values)) {
		$error = createOpenSubject($values);
		if (!empty($error)) {
			$message = array('type' => 'error', 'message' => "Có lỗi xảy ra:" . $error);
		} else {
			$message = array('type' => 'success', 'message' => "Thêm thành công!");
		}
	}

}
require_once "header.php";

function getValue($name)
{
	if (!empty($_POST)) {
		if (isset($_POST[$name])) {
			return $_POST[$name];
		}
	}
	return "";
}

function input($options, $error)
{
	if (!isset($options['placeholder'])) {
		$options['placeholder'] = "";
	}
	if (!isset($options['type'])) {
		$options['type'] = "text";
	}
	$class = "input";
	if (!empty($error)) {
		$class .= ' is-danger';
	}
	if (!isset($options['value'])) {
		if (!empty($_POST)) {
			if (!empty($_POST[$options['name']])) {
				$options['value'] = $_POST[$options['name']];
			}
		}
		$options['value'] = '';
	}
	$html = "<div class=\"field\">";
	$html .= "<label class=\"label\">" . $options['label'] . "</label>";
	$html .= "<div class=\"control\">";
	$html .= '<input value="'.$options['value'].'" class="' . $class . '" type="' . $options['type'] . '" name="' . $options['name'] . '" placeholder="' . $options['placeholder'] . '" />';
	if (!empty($error)) {
		$html .= '<p class="help is-danger">' . $error . '</p>';
	}
	$html .= "</div>";
	$html .= "</div>";

	return $html;
}

$teachers = getTeachers();
?>
<div id="content">
    <div class="container">
        <div class="columns">
					<?php require_once "admin_menu.php"; ?>
            <div class="column is-9">
                <div class="columns">
                    <div class="column is-9">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-header-title">Thêm môn học</div>
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
                                <form method="post"
                                      action="<?php print path('/index.php?p=admin/open-subjects/create'); ?>">
																	<?php
																	print input(array('label' => 'Mã học phần', 'name' => 'ma_hoc_phan'), !empty($errors['ma_hoc_phan']) ? $errors['ma_hoc_phan']: NULL);
																	?>


                                    <div class="field">
                                        <label class="label">Giảng viên</label>
                                        <div class="control">
                                            <div class="select">
                                                <select name="giang_vien_id">
																									<?php foreach ($teachers as $teacher): ?>
                                                      <option value="<?php print $teacher['d']; ?>"><?php print $teacher['ho'] . " " . $teacher['ten']; ?></option>
																									<?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="control">
                                            <button type="submit" class="button is-link">Thêm môn học</button>
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