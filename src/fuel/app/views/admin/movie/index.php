<!--begin::App Main-->
<main class="app-main">
    <?php if (\Session::get_flash('success')): ?>
        <div class="alert alert-success m-4"><?= \Session::get_flash('success') ?></div>
    <?php endif; ?>
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Movies</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Movies</li>
                    </ol>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content Header-->
    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <!-- /.col -->
                <div class="col-md-12">
                    <!-- /.card -->
                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="card-title w-75">Danh sách Phim</h3>
                            <div class="card-tools w-25 d-flex justify-content-between align-items-center">
                                <!-- Ô TÌM KIẾM + ICON KÍNH LÚP LÀ NÚT SEARCH -->
                                <form method="get" class="form-inline w-50">
                                    <div class="input-group input-group-sm" style="width: 200px;">
                                        <input type="text" name="search" value="<?= \Security::htmlentities($search ?? '') ?>"
                                            class="form-control" placeholder="Tìm kiếm...">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-secondary">
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <!-- NÚT THÊM PHIM -->
                                <a href="<?= \Uri::create('admin/movies/create') ?>" class="btn btn-sm btn-primary ml-2">
                                    <i class="bi bi-plus-circle"></i> Thêm phim
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">ID</th>
                                        <th>Poster</th>
                                        <th>Title</th>
                                        <th>VN Title</th>
                                        <th>IMDB</th>
                                        <th>Duration</th>
                                        <th>Director</th>
                                        <th>Release Date</th>
                                        <th>Actors</th>
                                        <th style="width: 40px">Edit</th>
                                        <th style="width: 40px">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($movies as $movie): ?>
                                        <tr class="align-middle">
                                            <td><?php echo $movie->id; ?></td>
                                            <td><img src="<?php echo $movie->poster_url; ?>" width="50"></td>
                                            <td><?php echo $movie->title; ?></td>
                                            <td><?php echo $movie->title_vnm; ?></td>
                                            <td><?php echo $movie->imdb_rating; ?></td>
                                            <td><?php echo $movie->duration; ?></td>
                                            <td><?php echo $movie->director; ?></td>
                                            <td><?php echo $movie->release_date; ?></td>
                                            <td><?php echo $movie->actors; ?></td>
                                            <td><a href="<?= \Uri::create('admin/movies/' . $movie->id . '/edit') ?>" class="btn btn-sm btn-success"><i class="bi bi-pen"></i></a></td>
                                            <td><a href="<?= \Uri::create('admin/movies/' . $movie->id . '/delete') ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <?php if (!empty($pagination)): ?>
                            <div class="card-footer clearfix">
                                <?= html_entity_decode($pagination, ENT_COMPAT, "UTF-8"); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
</main>
<!--end::App Main-->

<style>
    .pagination {
        float: right;
    }

    .pagination a {
        position: relative;
        display: block;
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        text-decoration: none;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
</style>