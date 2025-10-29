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
            <form class="d-flex me-3" id="search-form">
                <div class="input-group rounded">
                    <input type="search" class="form-control rounded-start" placeholder="Tìm kiếm phim..." aria-label="Search" aria-describedby="search-button">
                    <button class="btn btn-outline-light" type="submit" id="search-button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <a href="<?= \Uri::create('login') ?>" class="btn btn-outline-light me-3">Đăng Nhập</a>
            <a href="#" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#registerModal">Đăng Ký</a>
        </div>
    </div>

    <!-- Popup Đăng Ký -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Đăng Ký</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (Session::get_flash('error')): ?>
                        <div class="alert alert-danger"><?= Session::get_flash('error') ?></div>
                    <?php endif; ?>
                    <?php if (Session::get_flash('success')): ?>
                        <div class="alert alert-success"><?= Session::get_flash('success') ?></div>
                    <?php endif; ?>
                    <form action="<?= \Uri::create('movie/register') ?>" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Tên đăng nhập</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Họ và tên</label>
                            <input type="text" name="full_name" id="full_name" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Đăng Ký</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <p>Đã có tài khoản? <a href="<?= \Uri::create('login') ?>" class="text-primary">Đăng nhập</a></p>
                </div>
            </div>
        </div>
    </div>
</header>