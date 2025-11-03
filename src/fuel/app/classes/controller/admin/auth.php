<?php
class Controller_Admin_Auth extends Controller
{
    public function action_login()
    {
        if (\Input::method() == 'POST') {
            $email = \Input::post('email');
            $password = \Input::post('password');

            $admin = Model_Admin::validate_login($email, $password);
            if ($admin) {
                \Session::set('admin_id', $admin->id);
                \Session::set('adminname', $admin->adminname);
                \Session::set('email', $admin->email);
                \Session::set_flash('success', 'Login successful.');
                \Response::redirect('admin');
            } else {
                \Session::set_flash('error', 'Invalid email or password.');
            }
        }

        return \View::forge('admin/login');
    }

    public function action_logout()
    {
        \Session::delete('admin_id');
        \Session::delete('email');
        \Session::set_flash('success', 'Logged out successfully.');
        \Response::redirect('admin/login');
    }

    public function action_register()
    {
        if (\Input::method() == 'POST') {
            $email = \Input::post('email');
            $password = \Input::post('password');
            $adminname = \Input::post('adminname');

            if (empty($email) || empty($password)) {
                \Session::set_flash('error', 'Email and password are required.');
            } else {
                $existing_admin = Model_Admin::find('first', array('where' => array('email' => $email)));
                if ($existing_admin) {
                    \Session::set_flash('error', 'Email already exists.');
                } else {
                    $salt = bin2hex(random_bytes(16));
                    $hashed_password = Model_Admin::hash_password($password, $salt);

                    $admin = Model_Admin::forge(array(
                        'email' => $email,
                        'adminname' => $adminname,
                        'password' => $hashed_password,
                        'salt' => $salt,
                        'last_login' => date('Y-m-d H:i:s'),
                    ));
                    if ($admin->save()) {
                        \Session::set_flash('success', 'Admin created successfully.');
                        \Response::redirect('admin/login');
                    } else {
                        \Session::set_flash('error', 'Failed to create admin.');
                    }
                }
            }
        }

        return \View::forge('admin/register');
    }
}
