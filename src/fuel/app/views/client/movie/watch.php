<section class="container my-5 pt-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-dark p-3 rounded shadow-sm">
            <li class="breadcrumb-item">
                <a href="/" class="text-decoration-none"><i class="fas fa-home"></i> Trang chủ</a>
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
                <?= html_entity_decode($current_episode->video_url, ENT_COMPAT, "UTF-8"); ?>
            </div>
        <?php else: ?>
            <p class="text-gray">Chưa có tập phim nào.</p>
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
                                    class="btn btn-sm <?= $current_episode && $current_episode->episode_number === $ep->episode_number ? 'btn-danger' : 'btn-outline-secondary' ?>">
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
                                    class="btn btn-sm <?= $current_episode && $current_episode->episode_number === $ep->episode_number ? 'btn-danger' : 'btn-outline-secondary' ?>">
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
    <!-- <div class="mb-5">
        <h4 class="fw-bold mb-3">Chia sẻ</h4>
        <?php if ($is_logged_in): ?>
            <div class="d-flex gap-2">
                <a href="/movie/share/<?= $movie->id ?>?platform=facebook" class="btn btn-primary">
                    <i class="fab fa-facebook-f"></i> Facebook
                </a>
                <a href="/movie/share/<?= $movie->id ?>?platform=twitter" class="btn btn-info">
                    <i class="fab fa-twitter"></i> Twitter
                </a>
                <a href="/movie/share/<?= $movie->id ?>?platform=whatsapp" class="btn btn-success">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
            </div>
        <?php else: ?>
            <p class="text-gray">Vui lòng <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">đăng nhập</a> để chia sẻ phim.</p>
        <?php endif; ?>
    </div> -->

    <!-- 4. Đánh giá phim (Star rating) -->
    <div class="mb-5">
        <h4 class="fw-bold mb-3">Đánh giá phim</h4>
        <div class="d-flex align-items-center mb-3">
            <span class="me-2">Điểm trung bình: <?= $avg_rating ?>/5</span>
            <div class="star-rating">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <!-- <?= (1 > ($i - $avg_rating)) ?
                                '-half-alt text-warning' :
                                ' text-gray' ?> -->
                    <?php if ($i <= floor($avg_rating)): ?>
                        <i class="fas fa-star text-warning"></i>
                    <?php else: ?>
                        <?php if (1 > ($i - $avg_rating)): ?>
                            <i class="fas fa-star-half-alt text-warning"></i>
                        <?php else: ?>
                            <i class="fas fa-star text-gray"></i>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
        </div>
        <?php if ($is_logged_in): ?>
            <form action="/movie/rate/<?= $movie->id ?>" method="POST" class="d-flex align-items-center gap-2">
                <select name="rating" class="form-select w-auto">
                    <option value="" selected hidden>Vote</option>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <option value="<?= $i ?>">
                            <?php for ($j = 1; $j <= $i; $j++): ?>
                                <span class="text-warning star-voting">&#xf005;</span>
                            <?php endfor; ?>
                        </option>
                    <?php endfor; ?>
                </select>
                <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
            </form>
        <?php else: ?>
            <p class="text-gray">Vui lòng <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">đăng nhập</a> để đánh giá phim.</p>
        <?php endif; ?>
    </div>

    <?php
    function render_comment($comment, $movie, $is_logged_in, $depth = 0)
    {
        $indent = $depth * 40; // Thụt lề 40px mỗi cấp
        $max_depth = 3; // Giới hạn độ sâu reply (tùy chọn)
    ?>
        <div class="list-group-item mb-2 p-3 border-start <?= $depth > 0 ? 'border-primary' : '' ?>"
            style="margin-left: <?= $indent ?>px;"
            data-comment-id="<?= $comment->id ?>">

            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <strong><?= e($comment->user->username) ?></strong>
                    <small class="text-gray ms-2"><?= date('d/m/Y H:i', strtotime($comment->created_at)) ?></small>
                </div>
                <?php if ($is_logged_in && $depth < $max_depth): ?>
                    <button class="btn btn-sm btn-link text-primary p-0 reply-btn"
                        data-comment-id="<?= $comment->id ?>">
                        <i class="fas fa-reply"></i> Trả lời
                    </button>
                <?php endif; ?>
            </div>

            <p class="mb-2 mt-2"><?= nl2br(e($comment->comment)) ?></p>

            <!-- Form trả lời (ẩn mặc định) -->
            <?php if ($is_logged_in && $depth < $max_depth): ?>
                <div class="reply-form mt-3" style="display: none;" data-parent-id="<?= $comment->id ?>">
                    <form action="<?= \Uri::create('/movie/reply/' . $movie->slug . '-' . sprintf('%06d', $movie->id)); ?>"
                        method="POST" class="reply-submit-form">
                        <input type="hidden" name="parent_id" value="<?= $comment->id ?>">
                        <div class="mb-2">
                            <textarea name="content" class="form-control form-control-sm"
                                rows="2" placeholder="Viết trả lời..." required></textarea>
                        </div>
                        <div class="d-flex gap-1">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fas fa-paper-plane"></i> Gửi
                            </button>
                            <button type="button" class="btn btn-sm btn-secondary cancel-reply">
                                Hủy
                            </button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

            <!-- Danh sách reply con -->
            <div class="replies mt-3">
                <?php
                $replies = \Model_Comment::query()
                    ->where('parent_id', $comment->id)
                    ->related('user')
                    ->order_by('created_at', 'ASC')
                    ->get();
                ?>
                <?php foreach ($replies as $reply): ?>
                    <?= render_comment($reply, $movie, $is_logged_in, $depth + 1); ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php
    }

    function view_reply_html($reply, $movie, $is_logged_in)
    {
        ob_start(); ?>
        <div class="list-group-item mb-2 p-3 border-start border-primary" style="margin-left: 40px;" data-comment-id="<?= $reply->id ?>">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <strong><?= e($reply->user->username) ?></strong>
                    <small class="text-gray ms-2"><?= date('d/m/Y H:i', strtotime($reply->created_at)) ?></small>
                </div>
                <?php if ($is_logged_in): ?>
                    <button class="btn btn-sm btn-link text-primary p-0 reply-btn" data-comment-id="<?= $reply->id ?>">
                        <i class="fas fa-reply"></i> Trả lời
                    </button>
                <?php endif; ?>
            </div>
            <p class="mb-0 mt-2"><?= nl2br(e($reply->comment)) ?></p>
        </div>
    <?php return ob_get_clean();
    }
    ?>
</section>
