<?php
namespace Fuel\Migrations;

class Add_title_vnm_to_movies
{
    public function up()
    {
        \DBUtil::add_fields('movies', [
            'title_vnm' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => true,
                'after' => 'title',
                'comment' => 'Tiêu đề tiếng Việt của phim',
            ],
        ]);
    }

    public function down()
    {
        \DBUtil::drop_fields('movies', ['title_vnm']);
    }
}
