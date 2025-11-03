<?php
class Controller_Admin_Movie extends Controller_Admin
{
    public function action_index()
    {
        $config = [
            'pagination_url' => \Uri::create('admin/movies'),
            'total_items'    => Model_Movie::count(),
            'per_page'       => 10,
            'uri_segment'    => 'page',
            'template'       => 'bootstrap3',
        ];

        $pagination = \Pagination::forge('movie_pagination', $config);

        // Tìm kiếm
        $query = Model_Movie::query()
            ->order_by('id', 'desc')
            ->limit($pagination->per_page)
            ->offset($pagination->offset);

        if ($search = \Input::get('search')) {
            $query->where_open()
                ->where('title', 'like', "%$search%")
                ->or_where('title_vnm', 'like', "%$search%")
                ->where_close();
        }

        $data['movies'] = $query->get();
        $data['pagination'] = $pagination->render();
        $data['search'] = $search;

        $view = \View::forge('admin/movie/index', $data);
        return Service_Admin_Layout::render($view);
    }

    public function action_create()
    {
        $categories = Model_Category::find('all', ['order_by' => ['name' => 'asc']]);
        $view = \View::forge('admin/movie/create');
        $view->set('categories', $categories, false);

        if (\Input::method() == 'POST') {
            $val = $this->validate_movie();
            if ($val->run()) {
                $movie = Model_Movie::forge();
                $this->save_movie($movie);
                \Session::set_flash('success', 'Thêm phim thành công!');
                \Response::redirect('admin/movie');
            } else {
                \Session::set_flash('validation_errors', $val->error());
                \Session::set_flash('old_input', \Input::post());
                \Session::set_flash('old_categories', \Input::post('categories', []));
            }
        }

        return Service_Admin_Layout::render($view);
    }

    public function action_update($id = null)
    {
        $movie = Model_Movie::find($id, ['related' => ['categories', 'episodes']]);
        if (!$movie) {
            \Session::set_flash('error', 'Phim không tồn tại!');
            \Response::redirect('admin/movie');
        }

        $categories = Model_Category::find('all', ['order_by' => ['name' => 'asc']]);
        $view = \View::forge('admin/movie/update');
        $view->set('movie', $movie, false);
        $view->set('categories', $categories, false);
        $view->set('selected_categories', array_column($movie->categories, 'id'), false);
        $view->set('episodes', $movie->episodes, false);

        // $view = \View::forge('admin/movie/update')
        //     ->set('movie', $movie, false)
        //     ->set('categories', Model_Category::find('all', ['order_by' => ['name' => 'asc']]), false)
        //     ->set('selected_categories', array_column($movie->categories, 'id'), false);

        if (\Input::method() == 'POST') {
            $val = $this->validate_movie($movie->id);
            if ($val->run()) {
                $this->save_movie($movie);
                \Session::set_flash('success', 'Cập nhật thành công!');
                \Response::redirect('admin/movie');
            } else {
                \Session::set_flash('validation_errors', $val->error());
                \Session::set_flash('old_input', \Input::post());
                \Session::set_flash('old_categories', \Input::post('categories', []));
                \Session::set_flash('old_episodes', \Input::post('episodes', []));
            }
        }

        return Service_Admin_Layout::render($view);
    }

    private function save_movie($movie)
    {
        // Gán các field
        $movie->title        = \Input::post('title');
        $movie->title_vnm    = \Input::post('title_vnm');
        $movie->slug         = \Input::post('slug') ?: Model_Movie::generate_slug($movie->title);
        $movie->imdb_rating  = \Input::post('imdb_rating') ?: null;
        $movie->duration     = \Input::post('duration');
        $movie->release_date = \Input::post('release_date');
        $movie->summary      = \Input::post('summary');
        $movie->director     = \Input::post('director');
        $movie->actors       = \Input::post('actors');
        $movie->status       = \Input::post('status');
        $movie->hashtag      = \Input::post('hashtag');
        $movie->is_featured  = \Input::post('is_featured') ? 1 : 0;

        // Upload poster
        if ($file = \Upload::get_files('poster_url')) {
            $this->upload_image($file, 'posters', $movie, 'poster_url');
        }

        // Upload banner
        if ($file = \Upload::get_files('banner_url')) {
            $this->upload_image($file, 'banners', $movie, 'banner_url');
        }

        $movie->save();

        // === 4. ĐỒNG BỘ DANH MỤC (DÙNG array_diff) ===
        $selected_cat_ids = array_map('intval', \Input::post('categories', []));

        $current_relations = \DB::select('category_id')
            ->from('movie_categories')
            ->where('movie_id', $movie->id)
            ->execute()
            ->as_array(null, 'category_id');

        $current_cat_ids = array_map('intval', $current_relations);

        // XÓA CÁC QUAN HỆ KHÔNG CÒN
        foreach (array_diff($current_cat_ids, $selected_cat_ids) as $cat_id) {
            \DB::delete('movie_categories')
                ->where('movie_id', $movie->id)
                ->where('category_id', $cat_id)
                ->execute();
        }

        // THÊM CÁC QUAN HỆ MỚI
        foreach (array_diff($selected_cat_ids, $current_cat_ids) as $cat_id) {
            \DB::insert('movie_categories')
                ->set(['movie_id' => $movie->id, 'category_id' => $cat_id])
                ->execute();
        }

        // === 5. ĐỒNG BỘ TẬP PHIM (DÙNG array_diff) ===
        $input_episodes = \Input::post('episodes', []);
        $movie_id = $movie->id;

        // Lấy episodes hiện tại từ DB
        $current_eps = \DB::select('id', 'episode_number', 'language', 'video_url')
            ->from('movie_episodes')
            ->where('movie_id', $movie_id)
            ->execute()
            ->as_array();

        $current_map = [];
        foreach ($current_eps as $ep) {
            $key = $ep['episode_number'] . '|' . $ep['language']; // key duy nhất
            $current_map[$key] = $ep['id'];
        }

        $input_map = [];
        // Trong phần xử lý episodes
        foreach ($input_episodes as $ep) {
            if (empty($ep['episode_number']) || empty($ep['language']) || empty($ep['video_url'])) continue;

            $key = trim($ep['episode_number']) . '|' . $ep['language'];
            $input_map[$key] = [
                'episode_number' => trim($ep['episode_number']),
                'language'       => $ep['language'],
                'video_url'      => trim($ep['video_url']) // LƯU NGUYÊN iframe
            ];
        }

        // XÓA CÁC TẬP KHÔNG CÒN TRONG INPUT
        foreach (array_diff_key($current_map, $input_map) as $id) {
            \DB::delete('movie_episodes')->where('id', $id)->execute();
        }

        // CẬP NHẬT HOẶC THÊM MỚI
        foreach ($input_map as $key => $data) {
            if (isset($current_map[$key])) {
                // Cập nhật
                \DB::update('movie_episodes')
                    ->set($data)
                    ->where('id', $current_map[$key])
                    ->execute();
            } else {
                // Thêm mới
                $data['movie_id'] = $movie_id;
                \DB::insert('movie_episodes')->set($data)->execute();
            }
        }
    }

    public function action_delete($id = null)
    {
        $movie = Model_Movie::find($id);
        if ($movie && $movie->delete()) {
            \Session::set_flash('success', 'Xóa thành công!');
        } else {
            \Session::set_flash('error', 'Xóa thất bại!');
        }
        \Response::redirect('admin/movie');
    }

    private function validate_movie($id = null)
    {
        $val = \Validation::forge();

        $val->add_field('title', 'Tên phim', 'required|max_length[255]');

        $val->add_field('slug', 'Slug', 'required|max_length[255]|match_pattern[/^[a-z0-9-]+$/]|unique[movies.slug.' . $id . ']');

        $val->add_field('imdb_rating', 'Điểm IMDb', 'numeric_min[0]|numeric_max[10]');

        $val->add_field('duration', 'Thời lượng', 'numeric_min[1]');

        $val->add_field('status', 'Chất lượng', 'required|in_list[hd,fullhd,4k,cam,trailer]');

        $val->add_field('hashtag', 'Hashtag', 'match_pattern[/^#[a-zA-Z0-9_-]+(\s#[a-zA-Z0-9_-]+)*$/]');

        // $val->add_field('categories', 'Danh mục', 'required|min_length[1]');

        return $val;
    }

    private function upload_image($file, $folder, $movie, $field)
    {
        \Upload::process([
            'path' => DOCROOT . "assets/uploads/$folder",
            'randomize' => true,
            'ext_whitelist' => ['jpg', 'jpeg', 'png', 'gif'],
            'max_size' => 5 * 1024 * 1024, // 5MB
        ]);

        if (\Upload::is_valid()) {
            \Upload::save();
            $saved_file = \Upload::get_files(0);
            $movie->{$field} = "/assets/uploads/$folder/" . $saved_file['saved_as'];
        }
    }
}
