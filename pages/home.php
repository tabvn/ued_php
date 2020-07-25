<?php require_once "header.php"; ?>
<section class="hero is-medium is-primary">
    <div class="hero-body">
        <div class="container">
            <div class="columns">
                <div class="column">
                    <h1 class="title is-2 is-spaced">
                        <?php
                        date_default_timezone_set('Asia/Ho_Chi_Minh');
                        $Hour = date('G');
                        if ( $Hour >= 5 && $Hour <= 11 ) {
                            echo "Good Morning";
                        } else if ( $Hour >= 12 && $Hour <= 18 ) {
                            echo "Good Afternoon";
                        } else if ( $Hour >= 19 || $Hour <= 4 ) {
                            echo "Good Evening";
                        }
                        ?> UEDer!
                    </h1>
                    <h2 class="subtitle">
                        Web đăng ký học phần trực tuyến.
                    </h2>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2 class="title">The Team</h2>
        <div class="columns">
            <div class="column">
                <article class="team box">
                    <div class="box-content">
                        <div class="avatar">
                            <img src="<?php print path('/assets/images/duy_binh_doan.jpg')?>"  alt=""/>
                        </div>
                        <h2 class="title has-text-centered">Đoàn Duy Bình</h2>
                        <h3 class="subtitle has-text-centered">Lecturer</h3>
                    </div>
                </article>
            </div>
            <div class="column">
                <article class="team box">
                    <div class="box-content">
                        <div class="avatar">
                            <img src="<?php print path('/assets/images/toan.jpg')?>"  alt=""/>
                        </div>
                        <h2 class="title has-text-centered">Nguyễn Đình Toản</h2>
                        <h3 class="subtitle has-text-centered">Student</h3>
                    </div>
                </article>
            </div>
            <div class="column">
                <article class="team box">
                    <div class="box-content">
                        <div class="avatar">
                            <img src="<?php print path('/assets/images/tien.jpg')?>"  alt=""/>
                        </div>
                        <h2 class="title has-text-centered">Ngô Lê Thuỷ Tiên</h2>
                        <h3 class="subtitle has-text-centered">Student</h3>
                    </div>
                </article>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <article class="team box">
                    <div class="box-content">
                        <div class="avatar">
                            <img src="<?php print path('/assets/images/khue.jpg')?>"  alt=""/>
                        </div>
                        <h2 class="title has-text-centered">Đào Ngọc Khuê</h2>
                        <h3 class="subtitle has-text-centered">Student</h3>
                    </div>
                </article>
            </div>
            <div class="column">
                <article class="team box">
                    <div class="box-content">
                        <div class="avatar">
                            <img src="<?php print path('/assets/images/sang.jpg')?>"  alt=""/>
                        </div>
                        <h2 class="title has-text-centered">Huỳnh Văn Sang</h2>
                        <h3 class="subtitle has-text-centered">Student</h3>
                    </div>
                </article>
            </div>
            <div class="column">
                <article class="team box">
                    <div class="box-content">
                        <div class="avatar">
                            <img src="<?php print path('/assets/images/truyen.jpg')?>"  alt=""/>
                        </div>
                        <h2 class="title has-text-centered">Lê Thị Thanh Truyền</h2>
                        <h3 class="subtitle has-text-centered">Student</h3>
                    </div>
                </article>
            </div>
        </div>
        <div class="columns">
            <div class="column is-one-third">
                <article class="team box">
                    <div class="box-content">
                        <div class="avatar">
                            <img src="<?php print path('/assets/images/phet.jpg')?>"  alt=""/>
                        </div>
                        <h2 class="title has-text-centered">Phetpho Panyanouvong</h2>
                        <h3 class="subtitle has-text-centered">Student</h3>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>