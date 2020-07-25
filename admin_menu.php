<?php
?>
<div class="column">
    <aside class="menu">
        <p class="menu-label">
            Sinh viên
        </p>
        <ul class="menu-list">
            <li>
                <?php print navLink('Sinh viên', '?p=admin/students', null);?>
            </li>
            <li>
                <?php print navLink('Thêm sinh viên', '?p=admin/students/create', null);?>
            </li>
        </ul>
        <p class="menu-label">
            Giảng viên
        </p>
        <ul class="menu-list">
            <li>
                <?php print navLink('Giảng viên', '?p=admin/teachers', null);?>
            </li>
            <li>
                <?php print navLink('Thêm giảng viên', '?p=admin/teachers/create', null);?>
            </li>
        </ul>
        <p class="menu-label">
            Môn học
        </p>
        <ul class="menu-list">
            <li>
                <?php print navLink('Môn học', '?p=admin/subjects', null);?>
            </li>
            <li>
                <?php print navLink('Thêm môn học', '?p=admin/subjects/create', null);?>
            </li>
        </ul>
        <p class="menu-label">
            Học phần
        </p>
        <ul class="menu-list">
            <li>
                <?php print navLink('Học phần đang mở', '?p=admin/open-subjects', null);?>
            </li>
            <li>
                <?php print navLink('Mở học phần mới', '?p=admin/open-subjects/create', null);?>
            </li>
        </ul>
        <p class="menu-label">
            Quản trị viên
        </p>
        <ul class="menu-list">
            <li>
                <?php print navLink('Quản trị viên', '?p=admin/users', null);?>
            </li>
            <li>
                <?php print navLink('Thêm quản trị viên', '?p=admin/users/create', null);?>
            </li>
        </ul>
    </aside>
</div>