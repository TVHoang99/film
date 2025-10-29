<?php
namespace Fuel\Migrations;

class Add_episode_to_movies
{
    public function up()
    {
        \DBUtil::add_fields('movies', [
            'episode' => [
                'type' => 'varchar',
                'constraint' => 50,
                'null' => true,
                'after' => 'language',
                'comment' => 'Thông tin tập phim (ví dụ: Phim lẻ, Tập 1, 1/12, Hoàn tất 12 tập)',
            ],
        ]);
    }

    public function down()
    {
        \DBUtil::drop_fields('movies', ['episode']);
    }
}
