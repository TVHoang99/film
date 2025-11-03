<?php

use Fuel\Core\View;

class Service_Admin_Layout
{
    public static function render($content)
    {
        $layout = View::forge('admin/components/layout');

        // assign variables for the view
        $layout->sidebar = 'sidebar';
        $layout->header = 'header';
        $layout->content = 'content';
        $layout->footer = 'footer';

        // another way to assign variables for the view
        $layout->set('sidebar', View::forge('admin/components/sidebar', ['logo' => View::forge('admin/components/logo')]));
        $layout->set('header', View::forge('admin/components/header'));
        $layout->set('content', $content);
        $layout->set('footer', View::forge('admin/components/footer'));

        return View::forge('admin/index', [
            'layout' => $layout,
        ]);
    }
}
