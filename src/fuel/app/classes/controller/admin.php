<?php
class Controller_Admin extends Controller
{
    public function before()
    {
        parent::before();
        if (!\Session::get('admin_id')) {
            \Response::redirect('admin/login');
        }
    }
}