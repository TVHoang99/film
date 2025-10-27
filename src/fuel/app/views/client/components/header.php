<header class="navbar navbar-expand-lg fixed-top bg-dark navbar-dark">
    <div class="container">
        <a href="index.html" class="navbar-brand">
            <img src="<?= \Uri::base() ?>assets/img/logo.png" height="60">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a href="index.html" class="nav-link text-white active">Trang Chủ</a></li>
                <li class="nav-item"><a href="movies.html?type=series" class="nav-link text-white">Phim Bộ</a></li>
                <li class="nav-item"><a href="movies.html?type=movie" class="nav-link text-white">Phim Lẻ</a></li>
                <li class="nav-item"><a href="movies.html?type=country" class="nav-link text-white">Quốc Gia</a></li>
                <li class="nav-item"><a href="movies.html?type=genre" class="nav-link text-white">Thể Loại</a></li>
            </ul>
            <form class="d-flex me-3" id="search-form">
                <div class="input-group rounded">
                    <input type="search" class="form-control rounded-start" placeholder="Tìm kiếm phim..." aria-label="Search" aria-describedby="search-button">
                    <button class="btn btn-outline-light" type="submit" id="search-button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <a href="login.html" class="btn btn-outline-light me-3">Đăng Nhập</a>
            <a href="register.html" class="btn btn-outline-light">Đăng Ký</a>
        </div>
    </div>
</header>
