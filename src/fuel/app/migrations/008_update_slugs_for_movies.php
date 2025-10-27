<?php

namespace Fuel\Migrations;

class Update_slugs_for_movies
{
    public function up()
    {
        // Lấy tất cả phim và tạo slug
        $movies = \DB::select()->from('movies')->execute()->as_array();
        foreach ($movies as $movie) {
            $slug = \Model_Movie::generate_slug($movie['title']);
            \DB::update('movies')
                ->set(['slug' => $slug])
                ->where('id', '=', $movie['id'])
                ->execute();
        }
    }

    public function down()
    {
        // Không cần xóa slug vì migration trước sẽ xóa cột
    }
}
