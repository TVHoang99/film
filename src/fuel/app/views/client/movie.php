<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Phim</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Header tương tự index.html -->
    <header class="navbar navbar-expand-lg fixed-top bg-dark navbar-dark">
        <div class="container">
            <a href="index.html" class="navbar-brand">
                <img src="https://placehold.co/100x50?text=Logo" alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a href="index.html" class="nav-link text-white">Trang Chủ</a></li>
                    <li class="nav-item"><a href="movies.html?type=series" class="nav-link text-white active">Phim Bộ</a></li>
                    <li class="nav-item"><a href="movies.html?type=movie" class="nav-link text-white">Phim Lẻ</a></li>
                    <li class="nav-item"><a href="movies.html?type=country" class="nav-link text-white">Quốc Gia</a></li>
                    <li class="nav-item"><a href="movies.html?type=genre" class="nav-link text-white">Thể Loại</a></li>
                </ul>
                <a href="login.html" class="btn btn-outline-light">Đăng Nhập</a>
            </div>
        </div>
    </header>

    <section class="container my-5 pt-5">
        <h2 class="mb-4">Danh Sách Phim</h2>
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="movie-card card">
                    <img src="https://placehold.co/200x300?text=Phim+1" class="card-img-top" alt="Phim 1">
                    <div class="card-body">
                        <h5 class="card-title">Phim 1</h5>
                        <p class="card-text">IMDB: 8.0 | 120 phút</p>
                        <a href="watch.html" class="btn btn-primary">Xem Phim</a>
                    </div>
                </div>
            </div>
            <!-- Thêm các phim khác -->
        </div>
    </section>

    <!-- Footer tương tự index.html -->
    <footer class="footer py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h5>Thông Tin</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Hỏi Đáp</a></li>
                        <li><a href="#">Chính Sách Bảo Mật</a></li>
                        <li><a href="#">Điều Khoản Sử Dụng</a></li>
                        <li><a href="#">Giới Thiệu</a></li>
                        <li><a href="#">Liên Hệ</a></li>
                    </ul>
                </div>
                <div class="col-md-9">
                    <p>Trang web xem phim trực tuyến cung cấp các bộ phim chất lượng cao. Copyright © 2025.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
