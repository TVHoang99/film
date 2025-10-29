<?php
namespace Fuel\Migrations;

class Add_hashtag_to_movies
{
    public function up()
    {
        \DBUtil::add_fields('movies', [
            'hashtag' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => true,
                'after' => 'language',
                'comment' => 'Hashtag phim (ví dụ: #phimhay, #action, #2025)',
            ],
        ]);

        // Tạo index để tìm kiếm nhanh theo hashtag
        \DBUtil::create_index('movies', 'hashtag', 'idx_hashtag');
    }

    public function down()
    {
        \DBUtil::drop_fields('movies', ['hashtag']);
        \DBUtil::drop_index('movies', 'idx_hashtag');
    }
}
