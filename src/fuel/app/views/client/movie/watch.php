<section class="container my-5 pt-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-dark p-3 rounded shadow-sm">
            <li class="breadcrumb-item">
                <a href="/" class="text-decoration-none"><i class="fas fa-home"></i>Trang chủ</a>
            </li>
            <span class="carousel-control-next-icon next-icon"></span>
            <li class="breadcrumb-item">
                <a href="/movie/<?= $movie->slug ?>-<?= sprintf('%06d', $movie->id) ?>" class="text-decoration-none">
                    <?= e($movie->title) ?>
                </a>
            </li>
            <span class="carousel-control-next-icon next-icon"></span>
            <li class="breadcrumb-item active" aria-current="page">
                Xem phim
            </li>
        </ol>
    </nav>

    <!-- 1. Frame xem phim -->
    <div class="mb-5">
        <h3 class="fw-bold mb-3"><?= e($movie->title_vnm ?: $movie->title) ?> - <?= e($current_episode ? $current_episode->episode_number : 'Phim lẻ') ?></h3>
        <?php if ($current_episode): ?>
            <div class="ratio ratio-16x9">
                <?= html_entity_decode($current_episode->video_url, ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?>
            </div>
        <?php else: ?>
            <p class="text-muted">Chưa có tập phim nào.</p>
        <?php endif; ?>
    </div>

    <!-- 2. Danh sách tập Vietsub và Thuyết minh -->
    <?php if (!empty($episodes)): ?>
        <div class="mb-5">
            <h4 class="fw-bold mb-3">Danh sách tập</h4>
            <ul class="nav nav-tabs mb-3">
                <li class="nav-item">
                    <a class="nav-link <?= $current_episode && $current_episode->language === 'vietsub' ? 'active' : '' ?>" href="#vietsub" data-bs-toggle="tab">Vietsub</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_episode && $current_episode->language === 'thuyết minh' ? 'active' : '' ?>" href="#thuyetminh" data-bs-toggle="tab">Thuyết minh</a>
                </li>
            </ul>
            <div class="tab-content">
                <!-- Vietsub -->
                <div class="tab-pane fade <?= $current_episode && $current_episode->language === 'vietsub' ? 'show active' : '' ?>" id="vietsub">
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach ($episodes as $ep): ?>
                            <?php if ($ep->language === 'vietsub'): ?>
                                <a href="/movie/<?= $movie->slug ?>-<?= sprintf('%06d', $movie->id) ?>/watch/<?= $ep->episode_number ?>/vietsub"
                                    class="btn btn-sm <?= $current_episode && $current_episode->episode_number === $ep->episode_number ? 'btn-primary' : 'btn-outline-secondary' ?>">
                                    <?= e($ep->episode_number) ?>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <!-- Thuyết minh -->
                <div class="tab-pane fade <?= $current_episode && $current_episode->language === 'thuyết minh' ? 'show active' : '' ?>" id="thuyetminh">
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach ($episodes as $ep): ?>
                            <?php if ($ep->language === 'thuyết minh'): ?>
                                <a href="/movie/<?= $movie->slug ?>-<?= sprintf('%06d', $movie->id) ?>/watch/<?= $ep->episode_number ?>/thuyết minh"
                                    class="btn btn-sm <?= $current_episode && $current_episode->episode_number === $ep->episode_number ? 'btn-primary' : 'btn-outline-secondary' ?>">
                                    <?= e($ep->episode_number) ?>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- 3. Chia sẻ -->
    <div class="mb-5">
        <h4 class="fw-bold mb-3">Chia sẻ</h4>
        <div class="d-flex gap-2">
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(Uri::current()) ?>" target="_blank" class="btn btn-primary">
                <i class="fab fa-facebook-f"></i> Facebook
            </a>
            <a href="https://twitter.com/intent/tweet?url=<?= urlencode(Uri::current()) ?>&text=<?= urlencode($movie->title_vnm ?: $movie->title) ?>" target="_blank" class="btn btn-info">
                <i class="fab fa-twitter"></i> Twitter
            </a>
            <a href="https://wa.me/?text=<?= urlencode('Xem ' . ($movie->title_vnm ?: $movie->title) . ': ' . Uri::current()) ?>" target="_blank" class="btn btn-success">
                <i class="fab fa-whatsapp"></i> WhatsApp
            </a>
        </div>
    </div>

    <!-- 4. Đánh giá phim (Star rating) -->
    <div class="mb-5">
        <h4 class="fw-bold mb-3">Đánh giá phim</h4>
        <div class="d-flex align-items-center mb-3">
            <span class="me-2">Điểm trung bình: <?= $avg_rating ?>/5</span>
            <div class="star-rating">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <i class="fas fa-star <?= $i <= round($avg_rating) ? 'text-warning' : 'text-muted' ?>"></i>
                <?php endfor; ?>
            </div>
        </div>
        <?php if (Auth::check()): ?>
            <form action="/movie/rate/<?= $movie->id ?>" method="POST" class="d-flex align-items-center gap-2">
                <select name="rating" class="form-select w-auto">
                    <option value="">Chọn điểm</option>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?> sao</option>
                    <?php endfor; ?>
                </select>
                <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
            </form>
        <?php else: ?>
            <p class="text-muted">Vui lòng <a href="/login">đăng nhập</a> để đánh giá phim.</p>
        <?php endif; ?>
    </div>

    <!-- 5. Bình luận phim -->
    <div class="mb-5">
        <h4 class="fw-bold mb-3">Bình luận</h4>
        <?php if (Auth::check()): ?>
            <form action="/movie/comment/<?= $movie->id ?>" method="POST" class="mb-4">
                <div class="mb-3">
                    <textarea name="content" class="form-control" rows="4" placeholder="Viết bình luận của bạn..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Gửi bình luận</button>
            </form>
        <?php else: ?>
            <p class="text-muted">Vui lòng <a href="/login">đăng nhập</a> để bình luận.</p>
        <?php endif; ?>

        <?php if (!empty($comments)): ?>
            <div class="list-group">
                <?php foreach ($comments as $comment): ?>

                    <div class="list-group-item mb-2 p-3">
                        <div class="d-flex justify-content-between">
                            <strong><?= e($comment->user->username) ?></strong>
                            <small class="text-muted"><?= date('d/m/Y H:i', strtotime($comment->created_at)) ?></small>
                        </div>
                        <p class="mb-0"><?= nl2br(e($comment->comment)) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-muted">Chưa có bình luận nào.</p>
        <?php endif; ?>
    </div>
</section>