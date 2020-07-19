<div class="column">
    <aside class="menu">
        <p class="menu-label">
            Sinh viên
        </p>
        <ul class="menu-list">
            <li><a href="<?php print path('/?p=admin/students'); ?>">Tất cả sinh viên</a></li>
            <li><a href="<?php print path("/?p=admin/students/create"); ?>">Thêm sinh viên</a></li>
        </ul>
        <p class="menu-label">
            Giảng viên
        </p>
        <ul class="menu-list">
            <li><a href="<?php print path('/?p=admin/teachers'); ?>">Tất cả giảng viên</a></li>
            <li><a href="<?php print path("/?p=admin/teachers/create"); ?>">Thêm giảng viên</a></li>
        </ul>
        <p class="menu-label">
            Môn học
        </p>
        <ul class="menu-list">
            <li><a href="<?php print path('/?p=admin/subjects'); ?>">Tất cả môn học</a></li>
            <li><a href="<?php print path("/?p=admin/subjects/create"); ?>">Thêm môn học</a></li>
        </ul>
        <p class="menu-label">
            Học phần
        </p>
        <ul class="menu-list">
            <li><a href="<?php print path('/?p=admin/open-subjects'); ?>">Học phần đang mở</a></li>
            <li><a href="<?php print path('/?p=admin/open-subjects/create'); ?>">Mở học phần mới</a></li>
        </ul>
        <p class="menu-label">
            Quản trị viên
        </p>
        <ul class="menu-list">
            <li><a href="<?php print path('/?p=admin/users'); ?>">Tất cả quản trị viên</a></li>
            <li><a href="<?php print path('/?p=admin/users/create'); ?>">Thêm quản trị viên</a></li>
        </ul>
    </aside>
</div>