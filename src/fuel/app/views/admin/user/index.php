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
                    <h3 class="mb-0">Users</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Users</li>
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
                        <div class="card-header">
                            <h3 class="card-title">Users</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">ID</th>
                                        <th>User name</th>
                                        <th>Email</th>
                                        <th>Full name</th>
                                        <th style="width: 40px">Edit</th>
                                        <th style="width: 40px">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user): ?>
                                        <tr class="align-middle">
                                            <td><?php echo $user->id; ?></td>
                                            <td><?php echo $user->username; ?></td>
                                            <td><?php echo $user->email; ?></td>
                                            <td><?php echo $user->full_name; ?></td>
                                            <td><a href="<?= \Uri::create('admin/users/' . $user->id . '/edit') ?>" class="btn btn-sm btn-success"><i class="bi bi-pen"></i></a></td>
                                            <td><a href="<?= \Uri::create('admin/users/' . $user->id . '/delete') ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i></a></td>
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