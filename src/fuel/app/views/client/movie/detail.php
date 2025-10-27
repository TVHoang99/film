<section class="container my-5 pt-5">
    <div class="row">
        <!-- Cột trái: Poster và thông tin phim -->
        <div class="col-md-4">
            <img src="<?= $movie->poster_url ?>" class="img-fluid rounded mb-3" alt="<?= $movie->title ?>">
            <h3><?= $movie->title ?></h3>
            <p><strong>IMDB:</strong> <?= $movie->imdb_rating ?></p>
            <p><strong>Thời lượng:</strong> <?= $movie->duration ?> phút</p>
            <p><strong>Ngày chiếu:</strong> <?= $movie->release_date ?></p>
            <p><strong>Thể loại:</strong> <?= implode(', ', array_column($movie->categories, 'name')) ?></p>
            <div class="mb-3">
                <strong>Đánh giá:</strong>
                <span class="star-rating"><?= str_repeat('⭐', round($avg_rating)) . str_repeat('☆', 5 - round($avg_rating)) ?></span> (<?= number_format($avg_rating, 1) ?>/5 từ <?= $rating_count ?> lượt đánh giá)
            </div>
            <a href="#video-player" class="btn btn-primary w-100 mb-3">Xem Phim</a>
        </div>
        <!-- Cột phải: Video và tóm tắt -->
        <div class="col-md-8">
            <video controls class="w-100 mb-4 rounded" id="video-player">
                <source src="<?= $movie->video_url ?>" type="video/mp4">
                Trình duyệt không hỗ trợ video.
            </video>
            <h4>Tóm tắt</h4>
            <p><?= $movie->summary ?></p>
        </div>
    </div>

    <!-- Đánh giá phim -->
    <div class="row mt-4">
        <div class="col-12">
            <h4>Đánh giá Phim</h4>
            <form id="rating-form" class="mb-4" action="/movie/rate/<?= $movie->slug ?>-<?= sprintf('%06d', $movie->id) ?>" method="post">
                <div class="mb-3">
                    <label for="rating" class="form-label">Chọn số sao:</label>
                    <select class="form-select w-auto d-inline-block" id="rating" name="rating" required>
                        <option value="">Chọn sao</option>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?> Sao</option>
                        <?php endfor; ?>
                    </select>
                    <button type="submit" class="btn btn-primary ms-2">Gửi đánh giá</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bình luận -->
    <div class="row mt-4">
        <div class="col-12">
            <h4>Bình luận</h4>
            <form id="comment-form" class="mb-4" action="/movie/comment/<?= $movie->slug ?>-<?= sprintf('%06d', $movie->id) ?>" method="post">
                <div class="mb-3">
                    <label for="comment" class="form-label">Bình luận của bạn:</label>
                    <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Gửi bình luận</button>
            </form>
            <div id="comments-list">
                <?php foreach ($comments as $comment): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="card-title"><?= $comment->user->username ?> <small class="text-muted"><?= date('Y-m-d H:i', strtotime($comment->created_at)) ?></small></h6>
                            <p class="card-text"><?= $comment->comment ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
