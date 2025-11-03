<?php

class Controller_Admin_Home extends Controller_Admin
{
    public function action_index()
    {
        $content = View::forge('admin/home/index');
        return Service_Admin_Layout::render($content);
    }
}
