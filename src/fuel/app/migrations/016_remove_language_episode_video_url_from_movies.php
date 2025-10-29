<?php
namespace Fuel\Migrations;

class Remove_language_episode_video_url_from_movies
{
    public function up()
    {
        \DBUtil::drop_fields('movies', [
            'language',
            'episode',
            'video_url',
        ]);
    }

    public function down()
    {
        \DBUtil::add_fields('movies', [
            'language' => [
                'type' => 'varchar',
                'constraint' => 50,
                'null' => false,
                'default' => 'phụ đề',
                'comment' => 'Ngôn ngữ: thuyết minh, phụ đề, origin, vietsub, engsub',
            ],
            'episode' => [
                'type' => 'varchar',
                'constraint' => 50,
                'null' => true,
                'comment' => 'Thông tin tập phim (ví dụ: Phim lẻ, Tập 1, 1/12, Hoàn tất 12 tập)',
            ],
            'video_url' => [
                'type' => 'text',
                'null' => true,
            ],
        ]);
    }
}
