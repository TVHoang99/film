<?php

use Fuel\Core\View;

class Controller_Home extends Controller
{
	protected $repository_category;

	public function __construct()
	{
		$this->repository_category = new Repository_Category();
	}

	public function action_index()
	{
		$categories = $this->repository_category->find_all([
			'related' => ['movies'],
		]);

		return Service_Layout::render(View::forge('client/home/movie_list', ['categories' => $categories]), true);
	}
}
