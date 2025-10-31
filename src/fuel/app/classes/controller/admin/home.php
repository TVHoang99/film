<?php

class Controller_Admin_Home extends Controller
{

    public function action_index()
    {
        return View::forge('admin/index');
    }
}
