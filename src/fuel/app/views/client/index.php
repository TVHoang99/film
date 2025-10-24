<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ - Xem Phim Trực Tuyến</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <?php echo Asset::css('client/style.css'); ?>
</head>

<body>
    <!-- Header -->
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

    <!-- Banner -->
    <section id="banner" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="dark-opacity"></div>
                <img src="<?= \Uri::base() ?>assets/img/film-1.png" class="d-block w-100" alt="Phim 1">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Phim Mới 1</h5>
                    <p>IMDB: 8.5 | Thời lượng: 120 phút | Ngày chiếu: 2025-10-01</p>
                    <p>Tóm tắt: Một bộ phim hành động kịch tính với cốt truyện hấp dẫn...</p>
                    <div>⭐⭐⭐⭐☆</div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="dark-opacity"></div>
                <img src="<?= \Uri::base() ?>assets/img/film-2.png" class="d-block w-100" alt="Phim 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Phim Mới 2</h5>
                    <p>IMDB: 7.8 | Thời lượng: 90 phút | Ngày chiếu: 2025-10-03</p>
                    <p>Tóm tắt: Một câu chuyện tình cảm động...</p>
                    <div>⭐⭐⭐☆☆</div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#banner" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#banner" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </section>

    <!-- Danh sách phim - Slider -->
    <section class="container my-5">
        <h2 class="mb-4">Phim Mới Update</h2>
        <div id="new-movies-carousel" class="carousel slide" data-bs-ride="false">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <div class="movie-card card">
                                <img src="https://placehold.co/200x300?text=Phim+1" class="card-img-top" alt="Phim 1">
                                <div class="card-body">
                                    <h5 class="card-title">Phim 1</h5>
                                    <p class="card-text">IMDB: 8.0 | 120 phút</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="movie-card card">
                                <img src="https://placehold.co/200x300?text=Phim+2" class="card-img-top" alt="Phim 2">
                                <div class="card-body">
                                    <h5 class="card-title">Phim 2</h5>
                                    <p class="card-text">IMDB: 7.8 | 100 phút</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="movie-card card">
                                <img src="https://placehold.co/200x300?text=Phim+3" class="card-img-top" alt="Phim 3">
                                <div class="card-body">
                                    <h5 class="card-title">Phim 3</h5>
                                    <p class="card-text">IMDB: 8.2 | 130 phút</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="movie-card card">
                                <img src="https://placehold.co/200x300?text=Phim+4" class="card-img-top" alt="Phim 4">
                                <div class="card-body">
                                    <h5 class="card-title">Phim 4</h5>
                                    <p class="card-text">IMDB: 7.5 | 110 phút</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <div class="movie-card card">
                                <img src="https://placehold.co/200x300?text=Phim+5" class="card-img-top" alt="Phim 5">
                                <div class="card-body">
                                    <h5 class="card-title">Phim 5</h5>
                                    <p class="card-text">IMDB: 8.1 | 115 phút</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="movie-card card">
                                <img src="https://placehold.co/200x300?text=Phim+6" class="card-img-top" alt="Phim 6">
                                <div class="card-body">
                                    <h5 class="card-title">Phim 6</h5>
                                    <p class="card-text">IMDB: 7.9 | 105 phút</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="movie-card card">
                                <img src="https://placehold.co/200x300?text=Phim+7" class="card-img-top" alt="Phim 7">
                                <div class="card-body">
                                    <h5 class="card-title">Phim 7</h5>
                                    <p class="card-text">IMDB: 8.3 | 125 phút</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="movie-card card">
                                <img src="https://placehold.co/200x300?text=Phim+8" class="card-img-top" alt="Phim 8">
                                <div class="card-body">
                                    <h5 class="card-title">Phim 8</h5>
                                    <p class="card-text">IMDB: 7.7 | 108 phút</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#new-movies-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#new-movies-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        </div>
    </section>

    <!-- Phim Hàn -->
    <section class="container my-5">
        <h2 class="mb-4">Phim Hàn</h2>
        <div id="korean-movies-carousel" class="carousel slide" data-bs-ride="false">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <div class="movie-card card">
                                <img src="https://placehold.co/200x300?text=Phim+Han+1" class="card-img-top" alt="Phim Han 1">
                                <div class="card-body">
                                    <h5 class="card-title">Phim Hàn 1</h5>
                                    <p class="card-text">IMDB: 7.5 | 100 phút</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="movie-card card">
                                <img src="https://placehold.co/200x300?text=Phim+Han+2" class="card-img-top" alt="Phim Han 2">
                                <div class="card-body">
                                    <h5 class="card-title">Phim Hàn 2</h5>
                                    <p class="card-text">IMDB: 7.8 | 95 phút</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="movie-card card">
                                <img src="https://placehold.co/200x300?text=Phim+Han+3" class="card-img-top" alt="Phim Han 3">
                                <div class="card-body">
                                    <h5 class="card-title">Phim Hàn 3</h5>
                                    <p class="card-text">IMDB: 8.0 | 110 phút</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="movie-card card">
                                <img src="https://placehold.co/200x300?text=Phim+Han+4" class="card-img-top" alt="Phim Han 4">
                                <div class="card-body">
                                    <h5 class="card-title">Phim Hàn 4</h5>
                                    <p class="card-text">IMDB: 7.6 | 105 phút</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <div class="movie-card card">
                                <img src="https://placehold.co/200x300?text=Phim+Han+5" class="card-img-top" alt="Phim Han 5">
                                <div class="card-body">
                                    <h5 class="card-title">Phim Hàn 5</h5>
                                    <p class="card-text">IMDB: 7.9 | 115 phút</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="movie-card card">
                                <img src="https://placehold.co/200x300?text=Phim+Han+6" class="card-img-top" alt="Phim Han 6">
                                <div class="card-body">
                                    <h5 class="card-title">Phim Hàn 6</h5>
                                    <p class="card-text">IMDB: 8.1 | 120 phút</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="movie-card card">
                                <img src="https://placehold.co/200x300?text=Phim+Han+7" class="card-img-top" alt="Phim Han 7">
                                <div class="card-body">
                                    <h5 class="card-title">Phim Hàn 7</h5>
                                    <p class="card-text">IMDB: 7.7 | 100 phút</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="movie-card card">
                                <img src="https://placehold.co/200x300?text=Phim+Han+8" class="card-img-top" alt="Phim Han 8">
                                <div class="card-body">
                                    <h5 class="card-title">Phim Hàn 8</h5>
                                    <p class="card-text">IMDB: 8.2 | 110 phút</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#korean-movies-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#korean-movies-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        </div>
    </section>

    <!-- Tương tự cho Phim Trung, Phim Mỹ, Phim Chiếu Rạp, Anime (mỗi danh mục có 8 phim, chia thành 2 carousel-item, mỗi item 4 phim) -->
    <!-- Ví dụ: Phim Trung -->
    <section class="container my-5">
        <h2 class="mb-4">Phim Trung</h2>
        <div id="chinese-movies-carousel" class="carousel slide" data-bs-ride="false">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <div class="movie-card card">
                                <img src="https://placehold.co/200x300?text=Phim+Trung+1" class="card-img-top" alt="Phim Trung 1">
                                <div class="card-body">
                                    <h5 class="card-title">Phim Trung 1</h5>
                                    <p class="card-text">IMDB: 7.4 | 115 phút</p>
                                </div>
                            </div>
                        </div>
                        <!-- Thêm 3 phim khác cho item đầu -->
                        <div class="col-md-3 mb-4">
                            <div class="movie-card card">
                                <img src="https://placehold.co/200x300?text=Phim+Trung+1" class="card-img-top" alt="Phim Trung 1">
                                <div class="card-body">
                                    <h5 class="card-title">Phim Trung 1</h5>
                                    <p class="card-text">IMDB: 7.4 | 115 phút</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="movie-card card">
                                <img src="https://placehold.co/200x300?text=Phim+Trung+1" class="card-img-top" alt="Phim Trung 1">
                                <div class="card-body">
                                    <h5 class="card-title">Phim Trung 1</h5>
                                    <p class="card-text">IMDB: 7.4 | 115 phút</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="movie-card card">
                                <img src="https://placehold.co/200x300?text=Phim+Trung+1" class="card-img-top" alt="Phim Trung 1">
                                <div class="card-body">
                                    <h5 class="card-title">Phim Trung 1</h5>
                                    <p class="card-text">IMDB: 7.4 | 115 phút</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <div class="movie-card card">
                                <img src="https://placehold.co/200x300?text=Phim+Trung+5" class="card-img-top" alt="Phim Trung 5">
                                <div class="card-body">
                                    <h5 class="card-title">Phim Trung 5</h5>
                                    <p class="card-text">IMDB: 7.8 | 120 phút</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="movie-card card">
                                <img src="https://placehold.co/200x300?text=Phim+Trung+5" class="card-img-top" alt="Phim Trung 5">
                                <div class="card-body">
                                    <h5 class="card-title">Phim Trung 5</h5>
                                    <p class="card-text">IMDB: 7.8 | 120 phút</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="movie-card card">
                                <img src="https://placehold.co/200x300?text=Phim+Trung+5" class="card-img-top" alt="Phim Trung 5">
                                <div class="card-body">
                                    <h5 class="card-title">Phim Trung 5</h5>
                                    <p class="card-text">IMDB: 7.8 | 120 phút</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="movie-card card">
                                <img src="https://placehold.co/200x300?text=Phim+Trung+5" class="card-img-top" alt="Phim Trung 5">
                                <div class="card-body">
                                    <h5 class="card-title">Phim Trung 5</h5>
                                    <p class="card-text">IMDB: 7.8 | 120 phút</p>
                                </div>
                            </div>
                        </div>
                        <!-- Thêm 3 phim khác cho item thứ hai -->
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#chinese-movies-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#chinese-movies-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        </div>
    </section>
    <!-- Tương tự cho Phim Mỹ, Phim Chiếu Rạp, Anime -->

    <!-- Footer -->
    <footer class="footer py-4 bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col-md-6 notice">
                    <p>FilmHub - Trang xem phim online chất lượng cao miễn phí Vietsub, thuyết minh, lồng tiếng full HD. Kho phim mới khổng lồ, phim chiếu rạp, phim bộ, phim lẻ từ nhiều quốc gia như Việt Nam, Hàn Quốc, Trung Quốc, Thái Lan, Nhật Bản, Âu Mỹ… đa dạng thể loại. Khám phá nền tảng phim trực tuyến hay nhất 2024 chất lượng 4K! </p>
                    <p>Trang web có giao diện trực quan, thuận tiện, tốc độ tải nhanh, thường xuyên cập nhật các bộ phim mới, hứa hẹn đem lại trải nghiệm tốt cho người yêu phim.</p>
                    <br>
                    <br>
                    <p class="copyright">© 2025 Copyright</p>
                </div>
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
                <div class="col-md-3">
                    <h5>FilmHub</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Trang Chủ</a></li>
                        <li><a href="#">Phim Bộ</a></li>
                        <li><a href="#">Phim Lẻ</a></li>
                        <li><a href="#">Quốc Gia</a></li>
                        <li><a href="#">Thể Loại</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/client/script.js"></script>
</body>

</html>