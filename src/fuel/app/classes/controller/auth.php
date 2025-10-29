<?php
class Controller_Auth extends Controller
{
    public function action_register()
    {
        if (Session::get('user_id')) {
            Session::set_flash('error', 'Bạn đã đăng nhập.');
            Response::redirect('/');
        }

        if (Input::method() === 'POST') {
            $username = Input::post('username');
            $email = Input::post('email');
            $full_name = Input::post('full_name');
            $password = Input::post('password');
            $confirm_password = Input::post('confirm_password');

            // Kiểm tra mật khẩu xác nhận
            if ($password !== $confirm_password) {
                Session::set_flash('error', 'Mật khẩu xác nhận không khớp.');
                Response::redirect('auth/register');
            }

            // Kiểm tra trùng username hoặc email
            $existing_user = Model_User::query()
                ->where('username', $username)
                ->or_where('email', $email)
                ->get_one();

            if ($existing_user) {
                Session::set_flash('error', 'Tên đăng nhập hoặc email đã tồn tại.');
                Response::redirect('auth/register');
            }

            // Tạo user mới
            $user = Model_User::forge([
                'username' => $username,
                'email' => $email,
                'password_hash' => password_hash($password, PASSWORD_BCRYPT),
                'full_name' => $full_name,
            ]);

            if ($user->save()) {
                // Đăng nhập tự động
                Session::set('user_id', $user->id);
                Session::set('username', $user->username);
                Session::set_flash('success', 'Đăng ký thành công! Chào mừng bạn.');
                Response::redirect('/');
            } else {
                Session::set_flash('error', 'Không thể tạo tài khoản. Vui lòng thử lại.');
            }
        }

        return Response::forge(View::forge('auth/register'));
    }

    public function action_login()
    {
        if (Session::get('user_id')) {
            Session::set_flash('error', 'Bạn đã đăng nhập.');
            Response::redirect('/');
        }

        if (Input::method() === 'POST') {
            $username = Input::post('username');
            $password = Input::post('password');

            $user = Model_User::query()
                ->where('username', $username)
                ->get_one();

            if ($user && password_verify($password, $user->password_hash)) {
                Session::set('user_id', $user->id);
                Session::set('username', $user->username);
                Session::set_flash('success', 'Đăng nhập thành công.');
                Response::redirect('/');
            } else {
                Session::set_flash('error', 'Tên đăng nhập hoặc mật khẩu không đúng.');
            }
        }

        return Response::forge(View::forge('auth/login'));
    }

    public function action_logout()
    {
        Session::delete('user_id');
        Session::delete('username');
        Session::set_flash('success', 'Đăng xuất thành công.');
        Response::redirect('/');
    }
}
