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
	'_root_' => 'home/index',
	'movie/(:any)-(:num)' => 'movie/detail/$1/$2', // Khớp /movie/phim-hanh-dong-000001
    'movie/rate/(:any)-(:num)' => 'movie/rate/$1/$2',
    'movie/comment/(:any)-(:num)' => 'movie/comment/$1/$2',
);
