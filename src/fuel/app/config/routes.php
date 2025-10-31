<?php
/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.9-dev
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2019 Fuel Development Team
 * @link       https://fuelphp.com
 */

return array(
    // Route cho phim
	'_root_' => 'home/index',
	'movie/(:any)-(:num)' => 'movie/detail/$1/$2', // Khớp /movie/phim-hanh-dong-000001
    'movie/:slug-:id/watch(/:episode(/:language))?' => 'movie/watch/$1/$2/$3/$4',
    'movie/rate/(:any)-(:num)' => 'movie/rate/$1/$2',
    'movie/comment/:slug-:id' => 'movie/comment/$1/$2',
    'movie/share/(:any)-(:num)' => 'movie/share/$1/$2',

    // Route cho auth (user)
    'register' => 'auth/register',
    'login' => 'auth/login',
    'logout' => 'auth/logout',

    'search' => 'search/index',
    'search/suggest' => 'search/suggest',
    'ajax-search' => 'movie/ajax_search',

    // Route cho admin
    'admin/login' =>  'admin/auth/login',
    'admin/register' => 'admin/auth/register',
    'admin/' =>
);
