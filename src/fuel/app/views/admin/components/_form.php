<?php
$errors = \Session::get_flash('validation_errors', []);
$old = \Session::get_flash('old_input', []);
$old_categories = \Session::get_flash('old_categories', []);
$old_episodes = \Session::get_flash('old_episodes', []);

// Danh mục: ưu tiên old → selected → rỗng
$selected_cat_ids = $old_categories ?: ($selected_categories ?? []);

// Tập phim: ưu tiên old → DB → rỗng
$episodes = $episodes ?? [];
$all_episodes = !empty($old_episodes) ? $old_episodes : $episodes;
?>

<form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
    <?= \Form::csrf() ?>

    <div class="row g-4">
        <!-- CỘT TRÁI: THÔNG TIN CHÍNH -->
        <div class="col-lg-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Thông tin phim</h3>
                </div>
                <div class="card-body">

                    <!-- TÊN PHIM -->
                    <div class="mb-3 row">
                        <label for="title" class="col-sm-3 col-form-label">Tên phim <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" name="title" id="title"
                                value="<?= \Security::htmlentities($old['title'] ?? ($movie->title ?? '')) ?>"
                                class="form-control <?= isset($errors['title']) ? 'is-invalid' : '' ?>"
                                placeholder="Nhập tên phim..." required>
                            <?php if (isset($errors['title'])): ?>
                                <div class="invalid-feedback"><?= $errors['title']->get_message() ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- TÊN PHIM (TIẾNG VIỆT) -->
                    <div class="mb-3 row">
                        <label for="title_vnm" class="col-sm-3 col-form-label">Tên phim (Tiếng Việt)</label>
                        <div class="col-sm-9">
                            <input type="text" name="title_vnm" id="title_vnm"
                                value="<?= \Security::htmlentities($old['title_vnm'] ?? ($movie->title_vnm ?? '')) ?>"
                                class="form-control">
                        </div>
                    </div>

                    <!-- SLUG -->
                    <div class="mb-3 row">
                        <label for="slug" class="col-sm-3 col-form-label">Slug <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text">/movie/</span>
                                <input type="text" name="slug" id="slug"
                                    value="<?= \Security::htmlentities($old['slug'] ?? ($movie->slug ?? '')) ?>"
                                    class="form-control <?= isset($errors['slug']) ? 'is-invalid' : '' ?>"
                                    placeholder="tự động tạo" required>
                            </div>
                            <div class="form-text">Tự động tạo từ tên phim nếu để trống</div>
                            <?php if (isset($errors['slug'])): ?>
                                <div class="invalid-feedback"><?= $errors['slug']->get_message() ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- IMDB -->
                    <div class="mb-3 row">
                        <label for="imdb_rating" class="col-sm-3 col-form-label">IMDB</label>
                        <div class="col-sm-9">
                            <input type="number" step="0.1" min="0" max="10" name="imdb_rating" id="imdb_rating"
                                value="<?= $old['imdb_rating'] ?? ($movie->imdb_rating ?? '') ?>"
                                class="form-control <?= isset($errors['imdb_rating']) ? 'is-invalid' : '' ?>"
                                placeholder="7.5">
                            <?php if (isset($errors['imdb_rating'])): ?>
                                <div class="invalid-feedback"><?= $errors['imdb_rating']->get_message() ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- THỜI LƯỢNG -->
                    <div class="mb-3 row">
                        <label for="duration" class="col-sm-3 col-form-label">Thời lượng (phút)</label>
                        <div class="col-sm-9">
                            <input type="number" min="1" name="duration" id="duration"
                                value="<?= $old['duration'] ?? ($movie->duration ?? '') ?>"
                                class="form-control <?= isset($errors['duration']) ? 'is-invalid' : '' ?>"
                                placeholder="120">
                            <?php if (isset($errors['duration'])): ?>
                                <div class="invalid-feedback"><?= $errors['duration']->get_message() ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- NGÀY PHÁT HÀNH -->
                    <div class="mb-3 row">
                        <label for="release_date" class="col-sm-3 col-form-label">Ngày phát hành</label>
                        <div class="col-sm-9">
                            <input type="date" name="release_date" id="release_date"
                                value="<?= $old['release_date'] ?? ($movie->release_date ?? '') ?>"
                                class="form-control">
                        </div>
                    </div>

                    <!-- TÓM TẮT -->
                    <div class="mb-3 row">
                        <label for="summary" class="col-sm-3 col-form-label">Tóm tắt</label>
                        <div class="col-sm-9">
                            <textarea name="summary" id="summary" rows="5"
                                class="form-control <?= isset($errors['summary']) ? 'is-invalid' : '' ?>"
                                placeholder="Mô tả ngắn về phim..."><?= \Security::htmlentities($old['summary'] ?? ($movie->summary ?? '')) ?></textarea>
                        </div>
                    </div>

                    <!-- ĐẠO DIỄN -->
                    <div class="mb-3 row">
                        <label for="director" class="col-sm-3 col-form-label">Đạo diễn</label>
                        <div class="col-sm-9">
                            <input type="text" name="director" id="director"
                                value="<?= \Security::htmlentities($old['director'] ?? ($movie->director ?? '')) ?>"
                                class="form-control">
                        </div>
                    </div>

                    <!-- DIỄN VIÊN -->
                    <div class="mb-3 row">
                        <label for="actors" class="col-sm-3 col-form-label">Diễn viên</label>
                        <div class="col-sm-9">
                            <input type="text" name="actors" id="actors"
                                value="<?= \Security::htmlentities($old['actors'] ?? ($movie->actors ?? '')) ?>"
                                class="form-control"
                                placeholder="Diễn viên 1, Diễn viên 2...">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CỘT PHẢI: CÀI ĐẶT, ẢNH & TẬP PHIM -->
        <div class="col-lg-6">
            <!-- CARD: ẢNH & CÀI ĐẶT -->
            <div class="card card-success card-outline mb-4">
                <div class="card-header">
                    <h3 class="card-title">Hình ảnh & Cài đặt</h3>
                </div>
                <div class="card-body">

                    <!-- POSTER -->
                    <div class="mb-3">
                        <label class="form-label">Poster</label>
                        <div class="input-group">
                            <input type="file" name="poster_url" class="form-control" accept="image/*">
                            <label class="input-group-text">Chọn</label>
                        </div>
                        <?php if (!empty($movie->poster_url)): ?>
                            <img src="<?= $movie->poster_url ?>" class="img-fluid rounded mt-2" style="max-height: 150px;">
                        <?php endif; ?>
                    </div>

                    <!-- BANNER -->
                    <div class="mb-3">
                        <label class="form-label">Banner</label>
                        <div class="input-group">
                            <input type="file" name="banner_url" class="form-control" accept="image/*">
                            <label class="input-group-text">Chọn</label>
                        </div>
                    </div>

                    <!-- DANH MỤC -->
                    <div class="mb-3">
                        <label class="form-label">Danh mục <span class="text-danger">*</span></label>
                        <select name="categories[]" multiple class="form-control <?= isset($errors['categories']) ? 'is-invalid' : '' ?>" size="5" required>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat->id ?>" <?= in_array($cat->id, $selected_cat_ids) ? 'selected' : '' ?>>
                                    <?= \Security::htmlentities($cat->name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['categories'])): ?>
                            <div class="invalid-feedback"><?= $errors['categories']->get_message() ?></div>
                        <?php endif; ?>
                        <div class="form-text">Giữ <kbd>Ctrl</kbd> để chọn nhiều</div>
                    </div>

                    <!-- CHẤT LƯỢNG -->
                    <div class="mb-3">
                        <label class="form-label">Chất lượng <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <?php foreach (['hd' => 'HD', 'fullhd' => 'Full HD', '4k' => '4K', 'cam' => 'CAM', 'trailer' => 'Trailer'] as $val => $label): ?>
                                <option value="<?= $val ?>" <?= ($old['status'] ?? ($movie->status ?? '')) == $val ? 'selected' : '' ?>>
                                    <?= $label ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- HASHTAG -->
                    <div class="mb-3">
                        <label class="form-label">Hashtag</label>
                        <input type="text" name="hashtag" class="form-control"
                            value="<?= \Security::htmlentities($old['hashtag'] ?? ($movie->hashtag ?? '')) ?>"
                            placeholder="#phimhay #action...">
                    </div>

                    <!-- NỔI BẬT -->
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input type="checkbox" name="is_featured" value="1"
                                class="form-check-input" id="is_featured"
                                <?= ($old['is_featured'] ?? ($movie->is_featured ?? 0)) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_featured">Nổi bật</label>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <!-- CARD: TẬP PHIM -->
            <div class="card card-info card-outline">
                <div class="card-header d-flex justify-content-between align-items-center w-100">
                    <h3 class="card-title w-50">Tập phim</h3>
                    <div class="d-flex justify-content-end align-items-center w-50">
                        <button type="button" class="btn btn-sm btn-success" id="add-episode">
                            <i class="bi bi-plus"></i> Thêm tập
                        </button>
                    </div>

                </div>
                <div class="card-body" id="episodes-container">
                    <?php if (empty($all_episodes)): ?>
                        <p class="text-muted">Chưa có tập phim nào.</p>
                    <?php endif; ?>

                    <?php foreach ($all_episodes as $index => $ep): ?>
                        <div class="row mb-3 episode-row align-items-start">
                            <div class="col-md-3">
                                <label class="form-label">Tập <span class="text-danger">*</span></label>
                                <input type="text" name="episodes[<?= $index ?>][episode_number]"
                                    value="<?= \Security::htmlentities($ep->episode_number ?? $ep['episode_number'] ?? '') ?>"
                                    class="form-control" placeholder="Tập 1, Full..." required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Ngôn ngữ <span class="text-danger">*</span></label>
                                <select name="episodes[<?= $index ?>][language]" class="form-control" required>
                                    <option value="vietsub" <?= ($ep->language ?? $ep['language'] ?? '') === 'vietsub' ? 'selected' : '' ?>>Vietsub</option>
                                    <option value="thuyết minh" <?= ($ep->language ?? $ep['language'] ?? '') === 'thuyết minh' ? 'selected' : '' ?>>Thuyết minh</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Iframe video <span class="text-danger">*</span></label>
                                <textarea name="episodes[<?= $index ?>][video_url]"
                                    class="form-control" rows="3"
                                    placeholder="Dán thẻ &lt;iframe&gt;...&lt;/iframe&gt;" required><?= \Security::htmlentities($ep->video_url ?? $ep['video_url'] ?? '') ?></textarea>
                                <div class="form-text">Dán toàn bộ thẻ <code>&lt;iframe&gt;</code> từ YouTube, Google Drive...</div>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger btn-sm remove-episode">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Lưu
                    </button>
                    <a href="<?= \Uri::create('admin/movie') ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Hủy
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- JS: THÊM / XÓA TẬP PHIM -->
<script>
    document.getElementById('add-episode').addEventListener('click', function() {
        const container = document.getElementById('episodes-container');
        const index = container.querySelectorAll('.episode-row').length;
        const html = `
        <div class="row mb-3 episode-row d-flex align-items-center">
            <div class="col-md-3">
                <label class="form-label">Tập <span class="text-danger">*</span></label>
                <input type="text" name="episodes[${index}][episode_number]" class="form-control" placeholder="Tập 1..." required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Ngôn ngữ <span class="text-danger">*</span></label>
                <select name="episodes[${index}][language]" class="form-control" required>
                    <option value="vietsub">Vietsub</option>
                    <option value="thuyết minh">Thuyết minh</option>
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label">Iframe video <span class="text-danger">*</span></label>
                <textarea name="episodes[${index}][video_url]" 
                    class="form-control" rows="3" 
                    placeholder="Dán thẻ &lt;iframe&gt;...&lt;/iframe&gt;" required></textarea>
                <div class="form-text">Dán toàn bộ thẻ <code>&lt;iframe&gt;</code> từ YouTube, Google Drive...</div>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-sm remove-episode">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>`;
        container.insertAdjacentHTML('beforeend', html);
    });

    document.getElementById('episodes-container').addEventListener('click', function(e) {
        if (e.target.closest('.remove-episode')) {
            e.target.closest('.episode-row').remove();
        }
    });

    function convertYouTubeToIframe() {
        document.querySelectorAll('textarea[name$="[video_url]"]').forEach(textarea => {
            const val = textarea.value.trim();
            const youtubeRegex = /(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/;
            const match = val.match(youtubeRegex);
            if (match) {
                const videoId = match[1];
                const iframe = `<iframe width="560" height="315" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
                textarea.value = iframe;
            }
        });
    }

    // Gọi khi paste
    document.getElementById('episodes-container').addEventListener('paste', function(e) {
        setTimeout(convertYouTubeToIframe, 100);
    });
</script>

<!-- JS: VALIDATION BOOTSTRAP 5 -->
<script>
    (() => {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>