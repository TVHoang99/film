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
    'movie/([a-z0-9\-]+)-(\d{6})/watch(/:episode(/:language))?' => 'movie/watch/$2/$3/$4',
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
    'movie/reply/:slug-:id' => 'movie/reply/$1/$2',

    // Route cho admin
    'admin/login' =>  'admin/auth/login',
    'admin/logout' => 'admin/auth/logout',
    'admin/register' => 'admin/auth/register',
    'admin' => 'admin/home/index',
    // Users
    'admin/users' => 'admin/user/index',
    'admin/users/(:num)/edit' => 'admin/user/update/$1',
    'admin/users/(:id)/delete' => 'admin/user/delete/$1',
    // Categories
    'admin/categories' => 'admin/category/index',
    'admin/categories/create' => 'admin/category/create',
    'admin/categories/(:id)/edit'   => 'admin/category/update/$1',
    'admin/categories/(:id)/delete' => 'admin/category/delete/$1',
    // Movie
    'admin/movies' => 'admin/movie/index',
    'admin/movies/create' => 'admin/movie/create',
    'admin/movies/(:id)/edit' => 'admin/movie/update/$1',
    'admin/movies/(:id)/delete' => 'admin/movie/delete/$1',
);
