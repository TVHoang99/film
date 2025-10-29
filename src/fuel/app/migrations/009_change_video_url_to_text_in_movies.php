<?php
namespace Fuel\Migrations;

class Change_video_url_to_text_in_movies
{
    public function up()
    {
        // Đổi kiểu cột video_url thành TEXT
        \DBUtil::modify_fields('movies', [
            'video_url' => [
                'type' => 'text',
                'null' => true, // Cho phép NULL nếu cần
            ]
        ]);
    }

    public function down()
    {
        // Hoàn tác: Đổi lại thành VARCHAR(255)
        \DBUtil::modify_fields('movies', [
            'video_url' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => true,
            ]
        ]);
    }
}
