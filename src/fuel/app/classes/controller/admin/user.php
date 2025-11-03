<?php

class Controller_Admin_User extends Controller_Admin
{
    public function action_index()
    {
        $config = array(
            'pagination_url' => \Uri::create('admin/users'),
            'total_items'    => Model_User::count(),
            'per_page'       => 10,
            'uri_segment'    => 'page',
            'num_links'      => 5,
            'template'       => 'bootstrap3',
        );

        $pagination = \Pagination::forge('mypage', $config);

        $users = Model_User::find('all', array(
            'order_by' => ['id' => 'desc'],
            'limit'    => $pagination->per_page,
            'offset'   => $pagination->offset,
        ));

        $view = \View::forge('admin/user/index')
            ->set('users', $users, false)
            ->set('pagination', $pagination->render(), false);

        return Service_Admin_Layout::render($view);
    }

    public function action_update($id = null)
    {
        if (!$id || !is_numeric($id)) {
            \Session::set_flash('error', 'ID không hợp lệ!');
            \Response::redirect('admin/users');
        }

        $user = Model_User::find($id);

        if (!$user) {
            \Session::set_flash('error', 'User không tồn tại!');
            \Response::redirect('admin/users');
        }

        $view = \View::forge('admin/user/update')
            ->set('user', $user, false);

        return Service_Admin_Layout::render($view);
    }

    // === XỬ LÝ POST: CẬP NHẬT USER ===
    public function post_update($id = null)
    {
        if (!$id || !is_numeric($id)) {
            \Session::set_flash('error', 'ID không hợp lệ!');
            \Response::redirect('admin/users');
        }

        $user = Model_User::find($id);

        if (!$user) {
            \Session::set_flash('error', 'User không tồn tại!');
            \Response::redirect('admin/users');
        }

        // Lấy dữ liệu từ form
        $name  = \Input::post('name');
        $email = \Input::post('email');
        $password = \Input::post('password');
        $full_name = \Input::post('full_name');

        // Validate
        $val = \Validation::forge();
        $val->add_field('name', 'name', 'required|max_length[100]');
        $val->set_message('max_length', 'Maximum a hundred characters.');
        $val->add_field('password', 'Your password', 'required|match_pattern[/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/]');
        $val->set_message('match_pattern', 'Minimum eight characters, at least one letter and one number.');
        $val->add_field('email', 'Email address', 'valid_email');
        $val->add_field('full_name', 'Full name', 'required|max_length[100]');

        if ($val->run()) {
            // Cập nhật
            $user->name  = $name;
            $user->email = $email;
            $user->password_hash = password_hash($password, PASSWORD_BCRYPT);
            $user->full_name = $full_name;

            if ($user->save()) {
                \Session::set_flash('success', 'Cập nhật user thành công!');
                \Response::redirect('admin/users');
            } else {
                \Session::set_flash('error', 'Lỗi khi lưu dữ liệu!');
            }
        } else {
            \Session::set_flash('error', $val->error());
        }

        // Nếu lỗi → quay lại form với dữ liệu cũ
        $view = \View::forge('admin/user/update')
            ->set('user', $user, false)
            ->set('errors', $val->error(), false);

        return Service_Admin_Layout::render($view);
    }

    public function action_delete($id)
    {
        if (!$id || !is_numeric($id)) {
            \Session::set_flash('error', 'ID không hợp lệ!');
            \Response::redirect('admin/users');
        }

        $user = Model_User::find($id);

        if (!$user) {
            \Session::set_flash('error', 'User không tồn tại!');
            \Response::redirect('admin/users');
        }

        if ($user->delete()) {
            \Session::set_flash('success', 'Xoá user thành công!');
        } else {
            \Session::set_flash('error', 'Lỗi khi xoá!');
        }

        \Response::redirect('admin/users');
    }
}
