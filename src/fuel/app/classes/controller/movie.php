<?php
class Controller_Movie extends Controller
{
	protected $repository_movie;

	public function __construct()
	{
		$this->repository_movie = new Repository_Movie();
	}

	public function action_detail($slug, $id)
	{
		// Tìm phim theo slug
		$movie = $this->repository_movie->find_by_options([
			'where' => [
				['slug', '=', $slug],
				['id', '=', sprintf('%06d', $id)],
			],
		]);
		// echo '<pre>'; print_r($movie); echo '</pre>'; die;

		if ($movie) {
			// echo '<pre>'; print_r($movie['id']); echo '</pre>'; die;
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

		$data = [
			'movie' => $movie,
			'comments' => $movie->comments,
			'avg_rating' => $movie->average_rating(),
			'rating_count' => $movie->rating_count(),
		];

		// Render view
		return Service_Layout::render(View::forge('client/movie/detail', $data));
	}

	public function action_rate($slug, $id)
	{
		$movie = Model_Movie::query()
			->where('slug', $slug)
			->where('id', sprintf('%06d', $id))
			->get_one();

		if (!$movie) {
			Session::set_flash('error', 'Phim không tồn tại.');
			Response::redirect('/');
		}

		if (Input::method() === 'POST') {
			$user_id = Auth::get('id'); // Giả định dùng Auth
			if (!$user_id) {
				Session::set_flash('error', 'Bạn cần đăng nhập để đánh giá.');
				Response::redirect('movie/' . $slug . '-' . sprintf('%06d', $id));
			}

			$rating = Input::post('rating');
			$existing_rating = Model_Rating::query()
				->where('user_id', $user_id)
				->where('movie_id', $movie->id)
				->get_one();

			if ($existing_rating) {
				Session::set_flash('error', 'Bạn đã đánh giá phim này rồi.');
			} else {
				$rating_obj = Model_Rating::forge([
					'user_id' => $user_id,
					'movie_id' => $movie->id,
					'rating' => $rating,
				]);
				if ($rating_obj->save()) {
					Session::set_flash('success', 'Đánh giá đã được gửi!');
				} else {
					Session::set_flash('error', 'Lỗi khi gửi đánh giá.');
				}
			}
		}
		Response::redirect('movie/' . $slug . '-' . sprintf('%06d', $id));
	}

	public function action_comment($slug, $id)
	{
		$movie = Model_Movie::query()
			->where('slug', $slug)
			->where('id', sprintf('%06d', $id))
			->get_one();

		if (!$movie) {
			Session::set_flash('error', 'Phim không tồn tại.');
			Response::redirect('/');
		}

		if (Input::method() === 'POST') {
			$user_id = Auth::get('id'); // Giả định dùng Auth
			if (!$user_id) {
				Session::set_flash('error', 'Bạn cần đăng nhập để bình luận.');
				Response::redirect('movie/' . $slug . '-' . sprintf('%06d', $id));
			}

			$comment = Input::post('comment');
			$comment_obj = Model_Comment::forge([
				'user_id' => $user_id,
				'movie_id' => $movie->id,
				'comment' => $comment,
			]);
			if ($comment_obj->save()) {
				Session::set_flash('success', 'Bình luận đã được gửi!');
			} else {
				Session::set_flash('error', 'Lỗi khi gửi bình luận.');
			}
		}
		Response::redirect('movie/' . $slug . '-' . sprintf('%06d', $id));
	}
}
