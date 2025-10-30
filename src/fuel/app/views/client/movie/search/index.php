<section class="container my-5 pt-5">
    <h2 class="fw-bold mb-4">Kết quả tìm kiếm: <?= e($query) ?></h2>
    <?php if (empty($movies)): ?>
        <p class="text-gray">Không tìm thấy phim nào phù hợp với "<?= e($query) ?>".</p>
    <?php else: ?>
        <div class="row">
            <?php foreach ($movies as $movie): ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow-sm">
                        <a href="<?= \Uri::create('movie/' . $movie->slug . '-' . sprintf('%06d', $movie->id)) ?>">
                            <img src="<?= e($movie->poster_url) ?>" class="card-img-top" alt="<?= e($movie->title) ?>">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="<?= \Uri::create('movie/' . $movie->slug . '-' . sprintf('%06d', $movie->id)) ?>" class="text-decoration-none text-dark">
                                    <?= e($movie->title_vnm ?: $movie->title) ?>
                                </a>
                            </h5>
                            <p class="card-text text-muted small">
                                Lượt xem: <?= number_format($movie->views_count) ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
