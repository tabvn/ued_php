<?php
$subjects = array();
$message = null;
$db = Database::getConnection();
$stmt = $db->prepare("SELECT id, ten_mon_hoc FROM mon_hoc ORDER BY id");

if (!$stmt->execute()) {
    $message = array('type' => 'error', 'message' => htmlspecialchars($stmt->error));
} else {
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $result = array(
            'id' => NULL,
            'ten_mon_hoc' => NULL,
        );
        $stmt->bind_result(
            $result['id'],
            $result['ten_mon_hoc']
        );
        if ($stmt->num_rows > 0) {
            while ($stmt->fetch()) {
                $subjects[] = array(
                    'id' => $result['id'],
                    'ten_mon_hoc' => $result['ten_mon_hoc'],
                );
            }
        }
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
                        <div class="card-header-title">Danh sách môn học</div>
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
                                <th>Môn học</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($subjects as $subject): ?>
                                <tr>
                                    <td><?php print $subject['id'] ?></td>
                                    <td><?php print $subject['ten_mon_hoc'] ?></td>
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