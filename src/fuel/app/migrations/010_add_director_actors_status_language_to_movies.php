<?php
namespace Fuel\Migrations;

class Add_director_actors_status_language_to_movies
{
    public function up()
    {
        // Thêm các cột mới
        \DBUtil::add_fields('movies', [
            'director' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => true,
                'after' => 'summary',
                'comment' => 'Đạo diễn',
            ],
            'actors' => [
                'type' => 'text',
                'null' => true,
                'after' => 'director',
                'comment' => 'Danh sách diễn viên (có thể lưu dạng chuỗi hoặc JSON)',
            ],
            'status' => [
                'type' => 'enum',
                'constraint' => "'hd','cam','trailer'",
                'default' => 'hd',
                'null' => false,
                'after' => 'actors',
                'comment' => 'Trạng thái phim: hd, cam, trailer',
            ],
            'language' => [
                'type' => 'enum',
                'constraint' => "'thuyết minh','phụ đề','origin'",
                'default' => 'phụ đề',
                'null' => false,
                'after' => 'status',
                'comment' => 'Ngôn ngữ: thuyết minh, phụ đề, origin',
            ],
        ]);

        // Tạo index cho tìm kiếm nhanh (tùy chọn)
        \DBUtil::create_index('movies', 'status', 'idx_status');
        \DBUtil::create_index('movies', 'language', 'idx_language');
    }

    public function down()
    {
        // Xóa các cột khi rollback
        \DBUtil::drop_fields('movies', [
            'director',
            'actors',
            'status',
            'language',
        ]);

        // Xóa index (nếu có)
        \DBUtil::drop_index('movies', 'idx_status');
        \DBUtil::drop_index('movies', 'idx_language');
    }
}
