<?php
namespace Fuel\Migrations;

class Create_movie_categories
{
    public function up()
    {
        \DBUtil::create_table('movie_categories', [
            'movie_id' => ['type' => 'int', 'constraint' => 11, 'not_null' => true],
            'category_id' => ['type' => 'int', 'constraint' => 11, 'not_null' => true],
        ], ['movie_id', 'category_id'], false, 'InnoDB', 'utf8');

        // Thêm foreign keys
        \DBUtil::add_foreign_key('movie_categories', [
            'constraint' => 'fk_movie_categories_movie_id',
            'key' => 'movie_id',
            'reference' => [
                'table' => 'movies',
                'column' => 'id',
            ],
            'on_delete' => 'CASCADE',
        ]);

        \DBUtil::add_foreign_key('movie_categories', [
            'constraint' => 'fk_movie_categories_category_id',
            'key' => 'category_id',
            'reference' => [
                'table' => 'categories',
                'column' => 'id',
            ],
            'on_delete' => 'CASCADE',
        ]);

        // Thêm index cho category_id
        \DBUtil::create_index('movie_categories', 'category_id', 'idx_category_id');
    }

    public function down()
    {
        \DBUtil::drop_table('movie_categories');
    }
}
