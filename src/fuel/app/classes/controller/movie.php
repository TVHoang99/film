<?php

use Fuel\Core\Controller;

class Controller_Movie extends Controller
{
	protected $repository_movie;
	protected $repository_episode;
	protected $repository_comment;

	public function __construct()
	{
		$this->repository_movie = new Repository_Movie();
		$this->repository_episode = new Repository_Episode();
		$this->repository_comment = new Repository_Comment();
	}

	public function action_detail($slug, $id)
	{
		// Tìm phim theo slug
		$movie = $this->repository_movie->find_by_options([
			'where' => [
				['slug', '=', $slug],
				['id', '=', sprintf('%06d', $id)],
			],
			'related' => ['categories', 'episodes'],
		]);



		if ($movie) {
			$this->repository_movie->update($movie->id, [
				'views_count' => $movie->views_count + 1,
			]);
		} else {
			Session::set_flash('error', 'Phim không tồn tại.');
			Response::redirect('/');
		}

		// Lấy dữ liệu với quan hệ
		$movie = $this->repository_movie->find_by_options([
			'where' => [
				['slug', '=', $slug],
				['id', '=', sprintf('%06d', $id)],
			],
			'related' => ['categories', 'ratings', 'comments' => ['related' => 'user']],
		]);

		// Phim tương tự (cùng thể loại, khác ID, max 8)
		$category_ids = array_column($movie->categories, 'id');
		$similar_movies = [];
		if (!empty($category_ids)) {
			$similar_movies = $this->repository_movie->find_all([
				'related' => ['categories'],
				'where' => [
					['categories.id', 'IN', $category_ids],
					['id', '!=', $movie->id],
				],
				'order_by' => [
					['views_count', 'DESC']
				],
			]);
		}

		// Top thịnh hành
		// echo "<pre>";
		// print_r(array_column($movie->categories, 'name'));
		// echo "</pre>";
		// die;
		$category_names = array_column($movie->categories, 'name');
		$trending_movies_by_category = [];

		foreach ($category_names as $cat_name) {
			$top = $this->repository_movie->find_all([
				'related' => ['categories'],
				'where' => [
					['categories.name', $cat_name],
					['id', '!=', $movie->id],
				],
				'order_by' => [
					['views_count', 'DESC']
				],
			]);

			// $top = \DB::query('
			// 	SELECT
			// 		* 
			// 	FROM
			// 		`movies` AS T1
			// 		LEFT JOIN `movie_categories` AS `T2` ON `T1`.`id` = `T2`.`movie_id`
			// 		LEFT JOIN `categories` AS `T3` ON `T2`.`category_id` = `T3`.`id` 
			// 	WHERE
			// 		`T1`.`id` != 6 
			// 		AND T3.`name` = "Hành động" 
			// 	LIMIT 5
			// ');


			// echo "<pre>";
			// print_r($top);
			// echo "</pre>";
			// die;

			// echo DB::last_query();
			// die;

			if ($top) {
				// Lay dung moi category 6 bo phim
				$trending_movies_by_category[$cat_name] = array_slice($top, 0, 10);
			}
		}
		// echo "<pre>";
		// print_r($trending_movies_by_category);
		// echo "</pre>";
		// die;


		$data = [
			'movie' => $movie,
			'comments' => $movie->comments,
			'avg_rating' => $movie->average_rating(),
			'rating_count' => $movie->rating_count(),
			'similar_movies' => array_slice($similar_movies, 0, 8),
			'trending_movies_by_category' => $trending_movies_by_category,
		];

		// Render view
		return Service_Layout::render(View::forge('client/movie/detail', $data));
	}

	public function action_watch($slug, $id, $episode = 1, $language = 'vietsub')
	{
		// echo "<pre>"; var_dump($slug, $id, $episode, $language); echo "</pre>"; die;
		$movie = $this->repository_movie->find_by_options([
			'where' => [
				['slug', '=', $slug],
				['id', '=', sprintf('%06d', $id)],
			],
			'related' => ['categories', 'episodes'],
		]);

		if (!$movie) {
			Session::set_flash('error', 'Phim không tồn tại.');
			Response::redirect('/');
		}

		// Tăng lượt xem
		$this->repository_movie->update($movie->id, [
			'views_count' => $movie->views_count + 1,
		]);

		// Lấy tập phim
		$episodes = $movie->episodes;
		$current_episode = null;
		if ($episode) {
			// $current_episode = Model_Movie_Episode::query()
			// 	->where('movie_id', $movie->id)
			// 	->where('episode_number', $episode)
			// 	->where('language', $language)
			// 	->get_one();

			$current_episode = $this->repository_episode->find_by_options([
				'where' => [
					['movie_id', '=', $movie->id],
					['episode_number', '=', $episode],
					['language', '=', $language],
				],
			]);
		}
		if (!$current_episode && !empty($episodes)) {
			$current_episode = reset($episodes); // Lấy tập đầu tiên mặc định
		}

		// echo "<pre>";
		// print_r($current_episode);
		// echo "</pre>";
		// die;

		// Lấy bình luận
		// $comments = Model_Comment::query()
		// 	->where('movie_id', $movie->id)
		// 	->related('user')
		// 	->order_by('created_at', 'DESC')
		// 	->limit(10)
		// 	->get();
		$comments = $this->repository_comment->find_all([
			'where' => [
				['movie_id', '=', $movie->id],
			],
			'related' => ['user'],
			'order_by' => [
				['created_at', 'DESC']
			],
			'limit' => 10,
		]);
		// echo "<pre>"; var_dump($comments); echo "</pre>"; die;


		// Lấy đánh giá trung bình
		$avg_rating = \DB::select(\DB::expr('AVG(rating) as avg_rating'))
			->from('ratings')
			->where('movie_id', $movie->id)
			->execute()
			->get('avg_rating', 0);

		$data = [
			'movie' => $movie,
			'episodes' => $episodes,
			'current_episode' => $current_episode,
			'comments' => $comments,
			'avg_rating' => round($avg_rating, 1),
			'is_logged_in' => Session::get('user_id') ? true : false,
		];

		return Service_Layout::render(View::forge('client/movie/watch', $data));
	}

	public function action_rate($movie_id)
	{
		if (!Session::get('user_id')) {
			Session::set_flash('error', 'Vui lòng đăng nhập để đánh giá.');
			Response::redirect('auth/login');
		}

		if (Input::method() === 'POST') {
			$rating = Input::post('rating');
			$user_id = Session::get('user_id');

			$existing = Model_Rating::query()
				->where('movie_id', $movie_id)
				->where('user_id', $user_id)
				->get_one();

			if ($existing) {
				$existing->rating = $rating;
				$existing->save();
			} else {
				$new_rating = Model_Rating::forge([
					'movie_id' => $movie_id,
					'user_id' => $user_id,
					'rating' => $rating,
				]);
				$new_rating->save();
			}

			Session::set_flash('success', 'Đánh giá của bạn đã được gửi.');
		}

		Response::redirect('movie/' . Model_Movie::find($movie_id)->slug . '-' . sprintf('%06d', $movie_id) . '/watch');
	}

	public function action_comment($movie_id, $slug)
	{
		// Thêm log để debug
		\Log::debug('action_comment called: movie_id=' . $movie_id . ', slug=' . $slug . ', is_ajax=' . (Input::is_ajax() ? 'true' : 'false') . ', method=' . Input::method());

		// Kiểm tra nếu là AJAX request
		$is_ajax = Input::is_ajax();

		// Kiểm tra phim tồn tại và slug khớp
		$movie = Model_Movie::find($movie_id);
		if (!$movie || $movie->slug !== $slug) {
			if ($is_ajax) {
				return Response::forge(json_encode([
					'success' => false,
					'error' => 'Phim không tồn tại hoặc slug không khớp.'
				]), 404, ['Content-Type' => 'application/json']);
			}
			Session::set_flash('error', 'Phim không tồn tại hoặc slug không khớp.');
			Response::redirect('welcome/404');
		}

		// Xử lý POST (gửi bình luận)
		if (Input::method() === 'POST') {
			// Kiểm tra đăng nhập
			if (!Session::get('user_id')) {
				if ($is_ajax) {
					return Response::forge(json_encode([
						'success' => false,
						'error' => 'Vui lòng đăng nhập để bình luận.'
					]), 401, ['Content-Type' => 'application/json']);
				}
				Session::set_flash('error', 'Vui lòng đăng nhập để bình luận.');
				Response::redirect('auth/login');
			}

			$comment_text = Input::post('content', '');
			if (empty($comment_text) || strlen($comment_text) < 3) {
				if ($is_ajax) {
					return Response::forge(json_encode([
						'success' => false,
						'error' => 'Bình luận phải có ít nhất 3 ký tự.'
					]), 400, ['Content-Type' => 'application/json']);
				}
				Session::set_flash('error', 'Bình luận phải có ít nhất 3 ký tự.');
				Response::redirect('movie/' . $movie->slug . '-' . sprintf('%06d', $movie->id) . '/watch');
			}

			// Lưu bình luận
			$comment = Model_Comment::forge([
				'movie_id' => $movie_id,
				'user_id' => Session::get('user_id'),
				'comment' => $comment_text,
				'created_at' => time(),
			]);

			if ($comment->save()) {
				if ($is_ajax) {
					return Response::forge(json_encode([
						'success' => true,
						'user_name' => Session::get('username'),
						'comment' => $comment_text,
						'created_at' => date('d/m/Y H:i', time()),
					]), 200, ['Content-Type' => 'application/json']);
				}
				Session::set_flash('success', 'Bình luận đã được gửi.');
			} else {
				if ($is_ajax) {
					return Response::forge(json_encode([
						'success' => false,
						'error' => 'Lỗi khi gửi bình luận.'
					]), 500, ['Content-Type' => 'application/json']);
				}
				Session::set_flash('error', 'Lỗi khi gửi bình luận.');
			}

			Response::redirect('movie/' . $movie->slug . '-' . sprintf('%06d', $movie->id) . '/watch');
		}

		// Xử lý GET (trả về view cho yêu cầu không phải AJAX)
		$comments = Model_Comment::query()
			->where('movie_id', $movie_id)
			->related('user')
			->order_by('created_at', 'DESC')
			->limit(20)
			->get();

		$data = [
			'movie' => $movie,
			'comments' => $comments,
			'is_logged_in' => Session::get('user_id') ? true : false,
		];

		return Response::forge(View::forge('movie/watch', $data));
	}

	public function action_share($movie_id)
	{
		if (!Session::get('user_id')) {
			Session::set_flash('error', 'Vui lòng đăng nhập để chia sẻ.');
			Response::redirect('auth/login');
		}

		// Logic chia sẻ (giả lập, có thể tích hợp API mạng xã hội sau)
		Session::set_flash('success', 'Chia sẻ thành công!');
		Response::redirect('movie/' . Model_Movie::find($movie_id)->slug . '-' . sprintf('%06d', $movie_id) . '/watch');
	}

	public function action_search()
	{
		$q = Input::get('q', '');
		$movies = Model_Movie::query();

		if ($q && strpos($q, '#') === 0) {
			$movies->where('hashtag', 'LIKE', "%{$q}%");
		} else {
			$movies->where('title', 'LIKE', "%{$q}%");
		}

		$data = ['movies' => $movies->get()];
		return View::forge('search/results', $data);
	}

	public function action_ajax_search()
	{
		$query = Input::get('q', '');

		if (strlen($query) < 2) {
			return Response::forge(json_encode([]));
		}

		$movies = Model_Movie::query()
			->where_open()
			->where('title', 'like', "%{$query}%")
			->or_where('title_vnm', 'like', "%{$query}%")
			->or_where('slug', 'like', "%{$query}%")
			->where_close()
			->order_by('views_count', 'DESC')
			->limit(5)
			->get([
				'id',
				'title',
				'title_vnm',
				'slug',
				'poster_url',
				'views_count',
				'imdb_rating'
			]);

		$results = [];
		foreach ($movies as $movie) {
			$results[] = [
				'id' => $movie->id,
				'title' => $movie->title_vnm ?: $movie->title,
				'slug' => $movie->slug,
				'url' => \Uri::create('movie/' . $movie->slug . '-' . sprintf('%06d', $movie->id)),
				'poster' => $movie->poster_url,
				'views' => number_format($movie->views_count),
				'rating' => $movie->imdb_rating,
			];
		}

		return Response::forge(json_encode($results));
	}
}
