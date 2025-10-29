<?php
function truncateString($string, $maxLength = 29)
{
    // Check if the string is already short enough
    if (mb_strlen($string) <= $maxLength) {
        return $string;
    }

    // Truncate the string and append the ellipsis
    $shortenedString = mb_substr($string, 0, $maxLength - 3);
    return $shortenedString . '...';
}
?>

<?php foreach ($categories as $category): ?>
    <section class="content container my-5">
        <h2 class="category mb-4"><?= $category['name']; ?></h2>
        <div id="carousel-<?= strtolower(str_replace(' ', '-', $category['name'])); ?>" class="carousel slide" data-bs-ride="false">
            <div class="carousel-inner">
                <?php
                $movies = $category['movies'];
                $movieCount = count($movies);
                $chunkSize = 4; // Số phim mỗi carousel-item
                $chunks = array_chunk($movies, $chunkSize); // Chia mảng phim thành các nhóm 4 phim
                $isFirst = true;
                ?>

                <?php foreach ($chunks as $chunk): ?>
                    <div class="carousel-item <?= $isFirst ? 'active' : ''; ?>">
                        <div class="row">
                            <?php foreach ($chunk as $movie): ?>
                                <div class="col-md-3 mb-4">
                                    <div class="movie-card card">
                                        <img src="<?= $movie['poster_url']; ?>" class="card-img-top" alt="<?= $movie['title']; ?>">
                                        <div class="overlay">
                                            <a href="<?php echo \Uri::create('movie/' . $movie['slug'] . '-' . sprintf('%06d', $movie['id'])); ?>" class="btn btn-warning btn-play">
                                                <i class="fas fa-play"></i>
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <a href="<?php echo \Uri::create('movie/' . $movie['slug'] . '-' . sprintf('%06d', $movie['id'])); ?>">
                                                <h5 class="card-title"><?= truncateString($movie['title']); ?></h5>
                                            </a>
                                            <div class="movie-info d-flex justify-content-between align-items-center">
                                                <p class="card-text text-secondary"><?= $movie['imdb_rating']; ?> | <?= $movie['duration']; ?> phút</p>
                                                <p class="text-muted">
                                                    <i class="far fa-eye"></i> <?= number_format($movie['views_count']) ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php $isFirst = false; ?>
                <?php endforeach; ?>
            </div>
            <?php if ($movieCount > $chunkSize): ?>
                <button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?= strtolower(str_replace(' ', '-', $category['name'])); ?>" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carousel-<?= strtolower(str_replace(' ', '-', $category['name'])); ?>" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            <?php endif; ?>
        </div>
    </section>
<?php endforeach; ?>
