<?php
namespace Fuel\Migrations;

class Create_comments
{
    public function up()
    {
        \DBUtil::create_table('comments', [
            'id' => ['type' => 'int', 'auto_increment' => true, 'constraint' => 11],
            'user_id' => ['type' => 'int', 'constraint' => 11, 'not_null' => true],
            'movie_id' => ['type' => 'int', 'constraint' => 11, 'not_null' => true],
            'comment' => ['type' => 'text', 'not_null' => true],
            'created_at' => ['type' => 'timestamp', 'default' => \DB::expr('CURRENT_TIMESTAMP')],
        ], ['id'], false, 'InnoDB', 'utf8');

        // Thêm foreign keys
        \DBUtil::add_foreign_key('comments', [
            'constraint' => 'fk_comments_user_id',
            'key' => 'user_id',
            'reference' => [
                'table' => 'users',
                'column' => 'id',
            ],
            'on_delete' => 'CASCADE',
        ]);

        \DBUtil::add_foreign_key('comments', [
            'constraint' => 'fk_comments_movie_id',
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
        \DBUtil::drop_table('comments');
    }
}
