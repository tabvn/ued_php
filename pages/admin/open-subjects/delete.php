<?php
$id = (int) $_GET['id'];
$db = Database::getConnection();
$db->query("DELETE FROM hoc_phan WHERE id = $id");

?>