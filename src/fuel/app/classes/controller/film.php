<?php

use Fuel\Core\Controller;

class Controller_film extends Controller
{
	/**
	 * The basic film
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
		return View::forge('client/index');
	}

	public function action_movie()
	{
		return View::forge('client/movie');
	}
}
