<?php foreach($categories as $category): ?>
<section class="container my-5">
    <h2 class="mb-4"><?= $category['name']; ?></h2>
    <div id="new-movies-carousel" class="carousel slide" data-bs-ride="false">
        <div class="carousel-inner">
            <?php foreach($category['movies'] as $key => $movie): ?>
                <?php $rowIndex = $key + 1; ?>
                <?php if ($rowIndex < 4 || $rowIndex % 4 == 0): ?>
                    <div class="carousel-item <?= $rowIndex < 4 ? 'active' : ''; ?>">
                <?php endif; ?>
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <div class="movie-card card">
                                <img src="<?= $movie['poster_url']; ?>" class="card-img-top" alt="<?= $movie['title']; ?>">
                                <div class="overlay">
                                    <a href="<?php echo \Uri::create('movie/'.$movie['slug'].'-'.sprintf('%06d', $movie['id'])); ?>" class="btn btn-warning btn-play">
                                        <i class="fas fa-play"></i>
                                    </a>
                                    </div>
                                <div class="card-body">
                                    <a href="/movie/<?= $movie['id']; ?>">
                                        <h5 class="card-title"><?= $movie['title']; ?></h5>
                                    </a>
                                    <p class="card-text text-secondary"><?= $movie['imdb_rating']; ?> | <?= $movie['duration']; ?> phút</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#new-movies-carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#new-movies-carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>
</section>
<?php endforeach; ?>
