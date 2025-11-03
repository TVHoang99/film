<?php

namespace Fuel\Migrations;

class Add_parent_id_to_comments
{
	public function up()
	{
		\DBUtil::add_fields('comments', [
			'parent_id' => ['type' => 'int', 'constraint' => 11, 'null' => true, 'after' => 'movie_id'],
		]);
		\DBUtil::create_index('comments', 'parent_id', 'idx_parent_id');
	}

	public function down()
	{
		\DBUtil::drop_fields('comments', 'parent_id');
		\DBUtil::drop_index('comments', 'idx_pparent_id');
	}
}
