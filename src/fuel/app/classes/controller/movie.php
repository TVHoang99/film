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
				'limit' => 8,
			]);
		}

		$data = [
			'movie' => $movie,
			'comments' => $movie->comments,
			'avg_rating' => $movie->average_rating(),
			'rating_count' => $movie->rating_count(),
			'similar_movies' => $similar_movies,
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

	public function action_comment($movie_id)
	{
		if (!Session::get('user_id')) {
            Session::set_flash('error', 'Vui lòng đăng nhập để bình luận.');
            Response::redirect('auth/login');
        }

        if (Input::method() === 'POST') {
            $comment = Model_Comment::forge([
                'movie_id' => $movie_id,
                'user_id' => Session::get('user_id'),
                'content' => Input::post('content'),
            ]);

            if ($comment->save()) {
                Session::set_flash('success', 'Bình luận của bạn đã được gửi.');
            } else {
                Session::set_flash('error', 'Không thể gửi bình luận.');
            }
        }

        Response::redirect('movie/' . Model_Movie::find($movie_id)->slug . '-' . sprintf('%06d', $movie_id) . '/watch');
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
}
