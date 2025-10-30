<section class="container my-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">
                <i class="fas fa-search"></i> Kết quả tìm kiếm "<?= e($query) ?>"
            </h2>
            <p class="text-gray">Tìm thấy <strong><?= $total_results ?></strong> phim</p>
        </div>
    </div>

    <?php if (!empty($movies)): ?>
        <div class="row g-3">
            <?php foreach ($movies as $movie): ?>
                <div class="col-md-3 col-sm-6">
                    <a href="<?= $movie->url ?>" class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-sm hover-shadow">
                            <img src="<?= $movie->poster_url ?>" class="card-img-top" alt="<?= e($movie->title) ?>" style="height: 250px; object-fit: cover;">
                            <div class="card-body p-3">
                                <h6 class="card-title text-dark mb-2"><?= e($movie->title_vnm ?: $movie->title) ?></h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-warning">
                                        <i class="fas fa-star"></i> <?= $movie->imdb_rating ?>
                                    </small>
                                    <small class="text-gray">
                                        <i class="far fa-eye"></i> <?= $movie->views ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-search fa-3x text-muted mb-3"></i>
            <h4 class="text-gray">Không tìm thấy phim nào</h4>
            <p class="text-gray">Thử tìm kiếm với từ khóa khác</p>
            <a href="<?= \Uri::create('/') ?>" class="btn btn-primary">Về trang chủ</a>
        </div>
    <?php endif; ?>
</section>
