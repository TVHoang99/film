<?php 
    $current_uri = \Uri::string();
    $uri_prefix_arr = explode('/', $current_uri);
    $prefix_item = $uri_prefix_arr[1] ?? 'active';
?>
<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <?php echo $logo; ?>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
                class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="<?php echo \Uri::create('admin/') ?>" class="nav-link <?php echo $prefix_item ?? ''?>">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo \Uri::create('admin/users') ?>" class="nav-link <?php echo $prefix_item == 'users' ? 'active' : ''?>">
                        <i class="nav-icon bi bi-person"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo \Uri::create('admin/categories') ?>" class="nav-link <?php echo $prefix_item == 'categories' ? 'active' : ''?>">
                        <i class="nav-icon bi bi-ui-checks-grid"></i>
                        <p>Categories</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo \Uri::create('admin/movies') ?>" class="nav-link <?php echo $prefix_item == 'movies' ? 'active' : ''?>">
                        <i class="bi bi-film"></i>
                        <p>Movies</p>
                    </a>
                </li>
            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
<!--end::Sidebar-->