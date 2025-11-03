<!-- Modal Đăng Nhập -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Đăng Nhập</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if (Session::get_flash('error')): ?>
                    <div class="alert alert-danger"><?= Session::get_flash('error') ?></div>
                <?php endif; ?>
                <form action="<?= \Uri::create('login') ?>" method="POST">
                    <div class="mb-3">
                        <label for="login_username" class="form-label">Tên đăng nhập</label>
                        <input type="text" name="username" id="login_username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="login_password" class="form-label">Mật khẩu</label>
                        <input type="password" name="password" id="login_password" class="form-control" required>
                    </div>
                    <input type="hidden" name="current_url" value="<?php echo (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
                    <button type="submit" class="btn btn-primary w-100">Đăng Nhập</button>
                </form>
            </div>
            <div class="modal-footer">
                <p>Chưa có tài khoản? <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#registerModal" onclick="closeLoginModal()">Đăng ký</a></p>
            </div>
        </div>
    </div>
</div>
