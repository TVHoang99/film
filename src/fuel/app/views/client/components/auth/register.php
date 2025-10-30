<!-- Popup Đăng Ký -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Đăng Ký</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if (Session::get_flash('error')): ?>
                    <div class="alert alert-danger"><?= Session::get_flash('error') ?></div>
                <?php endif; ?>
                <?php if (Session::get_flash('success')): ?>
                    <div class="alert alert-success"><?= Session::get_flash('success') ?></div>
                <?php endif; ?>
                <form action="<?= \Uri::create('register') ?>" method="POST">
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
                <p>Đã có tài khoản? <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#loginModal" onclick="closeRegisterModal()">Đăng nhập</a></p>
            </div>
        </div>
    </div>
</div>
