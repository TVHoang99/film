<section class="container my-5 pt-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-dark p-3 rounded shadow-sm align-middle">
            <li class="breadcrumb-item">
                <a href="/" class="text-decoration-none"><i class="fas fa-home"></i>Trang chủ</a>
            </li>
            <span class="carousel-control-next-icon next-icon"></span>
            <?php if (!empty($movie->categories)): ?>
                <li class="breadcrumb-item">
                    <a href="/movies?category=<?= urlencode(end($movie->categories)->name) ?>" class="text-decoration-none">
                        <?= e(end($movie->categories)->name) ?>
                    </a>
                </li>
            <?php endif; ?>
            <span class="carousel-control-next-icon next-icon"></span>
            <li class="breadcrumb-item active" aria-current="page">
                <?= e($movie->title) ?>
            </li>
        </ol>
    </nav>

    <div class="row">
        <!-- ==================== NỘI DUNG CHÍNH (Content) ==================== -->
        <div class="col-lg-8">

            <!-- PHẦN ĐẦU: Poster + Thông tin cơ bản -->
            <div class="row m-0 mb-4 bg-dark pt-3 pb-3 rounded">
                <!-- Trái: Poster + Button -->
                <div class="col-md-4 text-center">
                    <img src="<?= $movie->poster_url ?>" class="rounded shadow-sm mb-3 w-100" alt="<?= $movie->title ?>" style="object-fit: cover;">

                    <!-- Button Xem phim / Trailer -->
                    <?php if ($movie->status !== 'trailer'): ?>
                        <a href="/movie/<?= $movie->slug ?>-<?= sprintf('%06d', $movie->id) ?>/watch" class="btn btn-danger w-100 mb-2">
                            <i class="fas fa-play"></i> Xem Phim
                        </a>
                    <?php endif; ?>
                    <a href="/movie/<?= $movie->slug ?>-<?= sprintf('%06d', $movie->id) ?>/watch" target="_blank" class="btn btn-outline-primary w-100">
                        <i class="fas fa-video"></i> Xem Trailer
                    </a>
                </div>

                <!-- Phải: Thông tin phim -->
                <div class="col-md-8 rounded">
                    <h3 class="fw-bold text-uppercase mb-2 movie-title"><?= e($movie->title) ?></h3>
                    <small class="text-gray"><?= e($movie->title_vnm . " (" . date('Y', strtotime($movie->release_date)) . ")") ?></small>

                    <table class="bg-light-gray mt-3 rounded w-100">
                        <tbody class="p-3 w-100">
                            <tr>
                                <th class="text-gray p-3 pb-0 w-35">Trạng thái</th>
                                <td class="p-3 pb-0">
                                    <?php $languages = []; ?>
                                    <?php foreach ($movie->episodes as $episode): ?>
                                        <?php if(!in_array($episode->language, $languages)): ?>
                                            <?php array_push($languages, $episode->language); ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                    <?php foreach ($languages as $language): ?>
                                        <span class="badge bg-secondary text-light fw-semibold movie-status">
                                            <?= e(ucfirst($language)) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-gray p-3 pb-0 w-35">Đạo diễn</th>
                                <td class="p-3 pb-0">
                                    <a href="/movies?director=<?= e($movie->director) ?>" class="text-decoration-none fw-medium">
                                        <?= e($movie->director) ?>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-gray p-3 pb-0 w-35">Thời lượng</th>
                                <td class="p-3 pb-0"><?= e($movie->duration) . " phút" ?></td>
                            </tr>
                            <tr>
                                <th class="text-gray p-3 pb-0 w-35">Năm phát hành</th>
                                <td class="p-3 pb-0">
                                    <?= e(date('Y', strtotime($movie->release_date))) ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-gray p-3 w-35">Thể loại</th>
                                <td class="p-3">
                                    <?php $row_index = 1; ?>
                                    <?php foreach ($movie->categories as $cat): ?>
                                        <a href="/movies?category=<?= urlencode($cat->name) ?>" class="text-decoration-none fw-medium">
                                            <?= e($cat->name) ?>
                                        </a>
                                        <?= $row_index < count($movie->categories) ? ',' : '' ?>
                                        <?php $row_index++; ?>
                                    <?php endforeach; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- PHẦN THÂN TRÊN: Diễn viên -->
            <?php if ($movie->actors): ?>
                <div class="mb-4 p-3 bg-dark rounded">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-users"></i> Diễn viên
                    </h5>
                    <div class="d-flex flex-wrap gap-2">
                        <?php
                        $actors = array_filter(array_map('trim', explode(',', $movie->actors)));
                        foreach ($actors as $actor):
                            $actor = trim($actor);
                            if (!$actor) continue;
                        ?>
                            <a href="/search?q=<?= urlencode($actor) ?>" class="badge bg-warning text-dark text-decoration-none px-3 py-2">
                                <?= e($actor) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- PHẦN THÂN DƯỚI: Tóm tắt + Hashtag -->
            <div class="mb-5 p-3 bg-dark rounded">
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-align-left"></i> Tóm tắt nội dung
                </h5>
                <small class="text-gray lh-lg"><?= nl2br(e($movie->summary)) ?></small>

                <!-- Hashtag -->
                <?php if ($movie->hashtag): ?>
                    <div class="mt-3">
                        <strong class="text-gray">Hashtag:</strong>
                        <br>
                        <?php
                        $hashtags = preg_split('/\s+/', trim($movie->hashtag));
                        foreach ($hashtags as $tag):
                            if (strpos($tag, '#') === 0):
                        ?>
                                <a href="/search?q=<?= urlencode($tag) ?>" class="badge bg-black text-gray text-decoration-none me-2 p-2 mt-1">
                                    <?= e($tag) ?>
                                </a>
                        <?php endif;
                        endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- PHẦN CUỐI: Phim đề cử -->
            <div class="mt-5">
                <h4 class="fw-bold mb-4 related-title">
                    <i class="fas fa-star"></i> Phim đề cử
                </h4>
                <?php if (!empty($similar_movies)): ?>
                    <div class="row g-3">
                        <?php foreach ($similar_movies as $similar): ?>
                            <div class="col-6 col-md-4 col-lg-3">
                                <a href="/movie/<?= $similar->slug ?>-<?= sprintf('%06d', $similar->id) ?>" class="text-decoration-none">
                                    <div class="card h-100 border-0 shadow-sm hover-shadow">
                                        <img src="<?= $similar->poster_url ?>" class="card-img-top" alt="<?= $similar->title ?>" style="object-fit: cover;">
                                        <div class="card-body p-2">
                                            <h6 class="card-title text-dark mb-1 text-truncate"><?= e($similar->title) ?></h6>
                                            <div class="movie-info d-flex justify-content-between align-items-center">
                                                <small class="card-text text-secondary"><?= $similar->imdb_rating; ?> | <?= $similar->duration; ?> phút</small>
                                                <small class="text-muted">
                                                    <i class="far fa-eye"></i> <?= number_format($similar->views_count) ?>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Chưa có phim tương tự.</p>
                <?php endif; ?>
            </div>

        </div>
        <!-- ==================== SIDEBAR ==================== -->
        <div class="col-lg-4">
            <div class="sticky-top" style="top: 100px;">
                <h5 class="fw-bold mb-3 text-danger">
                    <i class="fas fa-fire"></i> Phim thịnh hành
                </h5>

                <!-- Lấy danh sách category của phim hiện tại -->
                <?php
                $category_names = array_column($movie->categories, 'name');
                $trending_movies_by_category = [];

                foreach ($category_names as $cat_name) {
                    $top = \Model_Movie::query()
                        ->related('categories')
                        ->where('categories.name', $cat_name)
                        ->where('id', '!=', $movie->id) // Loại trừ phim hiện tại
                        ->order_by('views_count', 'DESC')
                        ->limit(5) // Top 5 phim
                        ->get();

                    if ($top) {
                        $trending_movies_by_category[$cat_name] = $top;
                    }
                }
                ?>

                <?php if (!empty($trending_movies_by_category)): ?>
                    <?php foreach ($trending_movies_by_category as $cat_name => $movies): ?>
                        <div class="mb-4 p-3 bg-dark rounded shadow-sm">
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="fas fa-star"></i> Top <?= e($cat_name) ?>
                            </h6>
                            <div class="list-group list-group-flush">
                                <?php foreach ($movies as $i => $m): ?>
                                    <a href="/movie/<?= $m->slug ?>-<?= sprintf('%06d', $m->id) ?>" class="list-group-item list-group-item-action d-flex align-items-center p-2">
                                        <span class="badge bg-<?= $i < 3 ? 'warning' : 'secondary' ?> me-2"><?= $i + 1 ?></span>
                                        <div class="d-flex flex-column flex-fill">
                                            <span class="text-dark text-truncate"><?= e($m->title) ?></span>
                                            <div class="movie-info d-flex justify-content-between align-items-center">
                                                <small class="card-text text-secondary"><?= $m->imdb_rating; ?> | <?= $m->duration; ?> phút</small>
                                                <small class="text-muted">
                                                    <i class="far fa-eye"></i> <?= number_format($m->views_count) ?>
                                                </small>
                                            </div>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">Chưa có phim thịnh hành.</p>
                <?php endif; ?>
            </div>
        </div>
        <!-- ==================== KẾT THÚC SIDEBAR ==================== -->
    </div>
</section>
