<header class="navbar navbar-expand-lg fixed-top bg-dark navbar-dark">
    <div class="header-container container">
        <a href="<?= \Uri::create('/') ?>" class="navbar-brand">
            <img src="<?= \Uri::base() ?>assets/img/logo.png" height="60">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a href="<?= \Uri::create('/') ?>" class="nav-link text-white active">Trang Chủ</a></li>
                <li class="nav-item"><a href="<?= \Uri::create('movies?type=series') ?>" class="nav-link text-white">Phim Bộ</a></li>
                <li class="nav-item"><a href="<?= \Uri::create('movies?type=movie') ?>" class="nav-link text-white">Phim Lẻ</a></li>
                <li class="nav-item"><a href="<?= \Uri::create('movies?type=country') ?>" class="nav-link text-white">Quốc Gia</a></li>
                <li class="nav-item"><a href="<?= \Uri::create('movies?type=genre') ?>" class="nav-link text-white">Thể Loại</a></li>
            </ul>
            <form class="d-flex me-3 position-relative w-25" id="search-form" action="<?= \Uri::create('search') ?>" method="GET">
                <div class="input-group rounded">
                    <input type="search" name="q" id="search-input" class="form-control rounded-start" placeholder="Tìm kiếm phim..." aria-label="Search">
                    <button class="btn btn-outline-light" type="submit" id="search-button"><i class="fas fa-search"></i></button>
                    <!-- Smart Hint Dropdown -->
                    <div id="search-dropdown" class="position-absolute top-100 start-0 w-100 border shadow-lg" style="display: none; overflow-y: auto; z-index: 1060;">
                        <div id="search-results" class="bg-light"></div>
                    </div>
                </div>
            </form>
            <?php if (Session::get('user_id')): ?>
                <span class="navbar-text text-white me-3">
                    Xin chào, <?= e(Session::get('full_name') ?: Session::get('username')) ?>
                </span>
                <a href="<?= \Uri::create('auth/logout') ?>" class="btn btn-outline-light">Đăng Xuất</a>
            <?php else: ?>
                <a href="#" class="btn btn-outline-light me-3" data-bs-toggle="modal" data-bs-target="#loginModal">Đăng Nhập</a>
                <a href="#" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#registerModal">Đăng Ký</a>
            <?php endif; ?>
        </div>
    </div>
</header>