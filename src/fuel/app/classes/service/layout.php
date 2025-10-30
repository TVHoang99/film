<?php

use Fuel\Core\View;

class Service_Layout
{
    public static function render($content, $has_banner = false)
    {
        $layout = View::forge('client/components/layout');

        // has it banner
        if ($has_banner) {
            $layout->banner = 'banner';
            $layout->set('banner', View::forge('client/components/banner'));
        } else {
            $layout->banner = '';
        }

		// assign variables for the view
		$layout->header = 'header';
		$layout->content = 'content';
		$layout->footer = 'footer';

		// another way to assign variables for the view
		$layout->set('header', View::forge('client/components/header'));
		$layout->set('content', $content);
		$layout->set('footer', View::forge('client/components/footer'));
		$layout->set('login', View::forge('client/components/auth/login'));
		$layout->set('register', View::forge('client/components/auth/register'));

        return View::forge('client/home/index', [
			'layout' => $layout,
		]);
    }
}