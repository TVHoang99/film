<?php
namespace Fuel\Migrations;

class Add_Banner_Url_To_Movies
{
    public function up()
    {
        \DBUtil::add_fields('movies', [
            'banner_url' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => true,
                'after' => 'poster_url'
            ],
        ]);
    }

    public function down()
    {
        \DBUtil::drop_fields('movies', ['banner_url']);
    }
}
