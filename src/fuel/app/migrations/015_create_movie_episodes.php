<?php
namespace Fuel\Migrations;

class Create_movie_episodes
{
    public function up()
    {
        \DBUtil::create_table('movie_episodes', [
            'id' => ['type' => 'int', 'auto_increment' => true, 'constraint' => 11],
            'movie_id' => ['type' => 'int', 'constraint' => 11, 'null' => false],
            'episode_number' => ['type' => 'varchar', 'constraint' => 50, 'null' => false, 'comment' => 'Số tập (ví dụ: Tập 1, 1/12)'],
            'language' => ['type' => 'varchar', 'constraint' => 50, 'null' => false, 'comment' => 'Ngôn ngữ: vietsub, thuyết minh'],
            'video_url' => ['type' => 'text', 'null' => false, 'comment' => 'URL video của tập'],
            'created_at' => ['type' => 'timestamp', 'default' => \DB::expr('CURRENT_TIMESTAMP')],
        ], ['id'], true, 'InnoDB', 'utf8mb4_unicode_ci');

        // Thêm foreign keys
        // Thêm foreign keys
        \DBUtil::add_foreign_key('movie_episodes', [
            'constraint' => 'fk_movie_episodes_movie_id',
            'key' => 'movie_id',
            'reference' => [
                'table' => 'movies',
                'column' => 'id',
            ],
            'on_delete' => 'CASCADE',
        ]);

        \DBUtil::create_index('movie_episodes', ['movie_id', 'episode_number', 'language'], 'idx_movie_episode', 'INDEX');
    }

    public function down()
    {
        \DBUtil::drop_table('movie_episodes');
    }
}
