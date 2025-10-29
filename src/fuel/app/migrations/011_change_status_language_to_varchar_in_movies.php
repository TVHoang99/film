<?php
namespace Fuel\Migrations;

class Change_status_language_to_varchar_in_movies
{
    public function up()
    {
        // Đổi status từ ENUM sang VARCHAR(50)
        \DBUtil::modify_fields('movies', [
            'status' => [
                'name' => 'status',
                'type' => 'varchar',
                'constraint' => 50,
                'null' => false,
                'default' => 'hd',
                'comment' => 'Trạng thái phim: hd, cam, trailer',
            ],
            'language' => [
                'name' => 'language',
                'type' => 'varchar',
                'constraint' => 50,
                'null' => false,
                'default' => 'phụ đề',
                'comment' => 'Ngôn ngữ: thuyết minh, phụ đề, origin',
            ],
        ]);

        // Cập nhật dữ liệu cũ (nếu cần) - ví dụ: đổi 'phụ đề' thành 'sub'
        // \DB::update('movies')->set(['language' => 'sub'])->where('language', 'phụ đề')->execute();
    }

    public function down()
    {
        // Hoàn tác: Đổi lại thành ENUM
        \DBUtil::modify_fields('movies', [
            'status' => [
                'name' => 'status',
                'type' => 'enum',
                'constraint' => "'hd','cam','trailer'",
                'default' => 'trailer',
                'null' => false,
            ],
            'language' => [
                'name' => 'language',
                'type' => 'enum',
                'constraint' => "'thuyết minh','phụ đề','origin'",
                'default' => 'phụ đề',
                'null' => false,
            ],
        ]);
    }
}
