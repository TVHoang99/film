<?php
namespace Fuel\Migrations;

class Create_ratings
{
    public function up()
    {
        \DBUtil::create_table('ratings', [
            'id' => ['type' => 'int', 'auto_increment' => true, 'constraint' => 11],
            'user_id' => ['type' => 'int', 'constraint' => 11, 'not_null' => true],
            'movie_id' => ['type' => 'int', 'constraint' => 11, 'not_null' => true],
            'rating' => ['type' => 'int', 'constraint' => 5, 'not_null' => true],
            'created_at' => ['type' => 'timestamp', 'default' => \DB::expr('CURRENT_TIMESTAMP')],
        ], ['id'], false, 'InnoDB', 'utf8');

        // Thêm constraint CHECK cho rating (1-5)
        \DB::query('ALTER TABLE ratings ADD CONSTRAINT check_rating CHECK (rating BETWEEN 1 AND 5)')->execute();

        // Thêm foreign keys
        \DBUtil::add_foreign_key('ratings', [
            'constraint' => 'fk_ratings_user_id',
            'key' => 'user_id',
            'reference' => [
                'table' => 'users',
                'column' => 'id',
            ],
            'on_delete' => 'CASCADE',
        ]);

        \DBUtil::add_foreign_key('ratings', [
            'constraint' => 'fk_ratings_movie_id',
            'key' => 'movie_id',
            'reference' => [
                'table' => 'movies',
                'column' => 'id',
            ],
            'on_delete' => 'CASCADE',
        ]);
    }

    public function down()
    {
        \DBUtil::drop_table('ratings');
    }
}
