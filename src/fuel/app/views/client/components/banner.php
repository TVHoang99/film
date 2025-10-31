<section id="banner" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php
        // echo "<pre>";
        // print_r($banners);
        // echo "</pre>";
        // die;
        ?>
        <?php if (!empty($banners)): ?>
            <?php $rowIndex = 1; ?>
            <?php foreach ($banners as $banner): ?>
                <div class="carousel-item <?= $rowIndex === 1 ? 'active' : '' ?>">
                    <div class="dark-opacity"></div>
                    <img src="<?= e($banner->banner_url) ?>" class="d-block w-100" alt="<?= e($banner->title_vnm ?: $banner->title) ?>">
                    <div class="carousel-caption d-none d-md-block">
                        <h5><?= e($banner->title_vnm ?: $banner->title) ?></h5>
                        <p>
                            IMDB: <?= e($banner->imdb_rating ?: 'N/A') ?> |
                            Thời lượng: <?= e($banner->duration ?: 'N/A') ?> phút |
                            Ngày chiếu: <?= e($banner->release_date ? date('d/m/Y', strtotime($banner->release_date)) : 'N/A') ?>
                        </p>
                        <p>Tóm tắt: <?= e(substr($banner->summary, 0, 100)) . (strlen($banner->summary) > 100 ? '...' : '') ?></p>
                        <div>
                            <?php
                            $rating = round($banner->imdb_rating);
                            for ($i = 1; $i <= 5; $i++) {
                                echo $i <= $rating ? '⭐' : '☆';
                            }
                            ?>
                        </div>
                        <a href="<?= \Uri::create('movie/' . $banner->slug . '-' . sprintf('%06d', $banner->id)) ?>" class="btn btn-watch-now mt-2"><i class="fas fa-play"></i>&nbsp;&nbsp;<span>Xem ngay</span></a>
                    </div>
                </div>
                <?php $rowIndex++; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="carousel-item active">
                <div class="dark-opacity"></div>
                <img src="https://placehold.co/1200x400?text=No+Banner" class="d-block w-100" alt="No Banner">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Chưa có phim mới</h5>
                    <p>Vui lòng quay lại sau!</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#banner" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#banner" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </button>
</section>