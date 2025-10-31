<?php

namespace Fuel\Migrations;

class Create_admins
{
    public function up()
    {
        \DBUtil::create_table('admins', [
            'id' => ['type' => 'int', 'unsigned' => true, 'auto_increment' => true, 'constraint' => 11],
            'adminname' => ['type' => 'varchar', 'constraint' => 50, 'not_null' => true],
            'email' => ['type' => 'varchar', 'constraint' => 100, 'not_null' => true],
            'password' => ['type' => 'varchar', 'constraint' => 255, 'not_null' => true],
            'salt' => ['type' => 'varchar', 'constraint' => 255, 'not_null' => true],
            'first_name' => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'last_name' => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'last_login' => ['type' => 'datetime', 'null' => true],
            'created_at' => ['type' => 'int', 'not_null' => true],
            'updated_at' => ['type' => 'int', 'null' => true],
        ], ['id'], true, 'InnoDB', 'utf8_unicode_ci');

        // Thêm index cho email để tìm kiếm nhanh hơn
        \DBUtil::create_index('admins', 'email', 'email_idx', 'UNIQUE');
        // Thêm index cho adminname
        \DBUtil::create_index('admins', 'adminname', 'adminname_idx', 'UNIQUE');
    }

    public function down()
    {
        \DBUtil::drop_table('admins');
    }
}
