<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">User Edit</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">User Edit</li>
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
            <div class="row g-4">
                <!--begin::Col-->
                <div class="col-md-12">
                    <!--begin::Quick Example-->
                    <div class="card">
                        <!--begin::Header-->
                        <div class="card-header">
                            <div class="card-title">User <?php echo ucfirst($user->username); ?></div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Form-->
                        <form class="needs-validation" method="post" action="<?= \Uri::create('admin/users/' . $user->id . '/edit') ?>" novalidate>
                            <?= \Form::csrf() ?>
                            <!--begin::Body-->
                            <div class="card-body">
                                <!--begin::Row-->
                                <div class="row g-3">
                                    <!--begin::Col-->
                                    <div class="col-md-12">
                                        <label for="validationCustom01" class="form-label">Name</label>
                                        <input
                                            type="text"
                                            name="name"
                                            class="form-control"
                                            id="validationCustom01"
                                            value="<?php echo $user->username; ?>"
                                            required />
                                        <?php if (isset($errors['username'])): ?>
                                            <div class="invalid-feedback">
                                                <?= $errors['username']->get_message() ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-md-12">
                                        <label for="validationCustom02" class="form-label">Email</label>
                                        <input
                                            type="email"
                                            name="email"
                                            class="form-control"
                                            id="validationCustom02"
                                            value="<?php echo $user->email; ?>"
                                            required />
                                        <?php if (isset($errors['email'])): ?>
                                            <div class="invalid-feedback">
                                                <?= $errors['email']->get_message() ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-md-12">
                                        <label for="validationCustom02" class="form-label">Password</label>
                                        <input
                                            type="text"
                                            name="password"
                                            class="form-control"
                                            id="validationCustom02"
                                            value=""
                                            placeholder="Minimum eight characters, at least one letter and one number."
                                            required />
                                        <?php if (isset($errors['password'])): ?>
                                            <div class="invalid-feedback">
                                                <?= $errors['password']->get_message() ?>
                                            </div>
                                        <?php endif; ?>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-12">
                                            <label for="validationCustom02" class="form-label">Full name</label>
                                            <input
                                                type="text"
                                                name="full_name"
                                                class="form-control"
                                                id="validationCustom02"
                                                value="<?php echo $user->full_name; ?>"
                                                required />
                                            <?php if (isset($errors['full_name'])): ?>
                                                <div class="invalid-feedback">
                                                    <?= $errors['full_name']->get_message() ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Body-->
                                <!--begin::Footer-->
                                <div class="card-footer">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="<?= \Uri::create('admin/user/index') ?>" class="btn btn-secondary">
                                        Back
                                    </a>
                                </div>
                                <!--end::Footer-->
                        </form>
                        <!--end::Form-->
                        <!--begin::JavaScript-->
                        <script>
                            // Example starter JavaScript for disabling form submissions if there are invalid fields
                            (() => {
                                'use strict';

                                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                                const forms = document.querySelectorAll('.needs-validation');

                                // Loop over them and prevent submission
                                Array.from(forms).forEach((form) => {
                                    form.addEventListener(
                                        'submit',
                                        (event) => {
                                            if (!form.checkValidity()) {
                                                event.preventDefault();
                                                event.stopPropagation();
                                            }

                                            form.classList.add('was-validated');
                                        },
                                        false,
                                    );
                                });
                            })();
                        </script>
                        <!--end::JavaScript-->
                    </div>
                    <!--end::Quick Example-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
</main>