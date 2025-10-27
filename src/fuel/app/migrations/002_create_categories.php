<?php
namespace Fuel\Migrations;

class Create_categories
{
    public function up()
    {
        \DBUtil::create_table('categories', [
            'id' => ['type' => 'int', 'auto_increment' => true, 'constraint' => 11],
            'name' => ['type' => 'varchar', 'constraint' => 100, 'not_null' => true],
            'description' => ['type' => 'text', 'null' => true],
            'created_at' => ['type' => 'timestamp', 'default' => \DB::expr('CURRENT_TIMESTAMP')],
        ], ['id'], false, 'InnoDB', 'utf8');

        // Thêm unique index cho name
        \DBUtil::create_index('categories', 'name', 'idx_name', 'UNIQUE');
    }

    public function down()
    {
        \DBUtil::drop_table('categories');
    }
}
