<?php
namespace Fuel\Migrations;

class Add_slug_to_movies
{
    public function up()
    {
        // Thêm cột slug vào bảng movies
        \DBUtil::add_fields('movies', [
            'slug' => [
                'type' => 'varchar',
                'constraint' => 255,
                'not_null' => true,
                'after' => 'title' // Đặt sau cột title
            ]
        ]);

        // Thêm unique index cho slug
        \DBUtil::create_index('movies', 'slug', 'idx_slug', 'UNIQUE');
    }

    public function down()
    {
        // Xóa cột slug
        \DBUtil::drop_fields('movies', ['slug']);
    }
}
