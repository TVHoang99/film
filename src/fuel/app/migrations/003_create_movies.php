<?php
namespace Fuel\Migrations;

class Create_movies
{
    public function up()
    {
        \DBUtil::create_table('movies', [
            'id' => ['type' => 'int', 'auto_increment' => true, 'constraint' => 11],
            'title' => ['type' => 'varchar', 'constraint' => 255, 'not_null' => true],
            'imdb_rating' => ['type' => 'decimal', 'constraint' => '3,1', 'null' => true],
            'duration' => ['type' => 'int', 'null' => true],
            'release_date' => ['type' => 'date', 'null' => true],
            'summary' => ['type' => 'text', 'null' => true],
            'poster_url' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'video_url' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'is_featured' => ['type' => 'tinyint', 'constraint' => 1, 'default' => 0],
            'views_count' => ['type' => 'int', 'default' => 0],
            'created_at' => ['type' => 'timestamp', 'default' => \DB::expr('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'timestamp', 'default' => \DB::expr('CURRENT_TIMESTAMP'), 'on_update' => \DB::expr('CURRENT_TIMESTAMP')],
        ], ['id'], false, 'InnoDB', 'utf8');

        // Thêm index cho is_featured
        \DBUtil::create_index('movies', 'is_featured', 'idx_is_featured');
    }

    public function down()
    {
        \DBUtil::drop_table('movies');
    }
}
