<?php
namespace Fuel\Migrations;

class Create_users
{
    public function up()
    {
        \DBUtil::create_table('users', [
            'id' => ['type' => 'int', 'auto_increment' => true, 'constraint' => 11],
            'username' => ['type' => 'varchar', 'constraint' => 50, 'not_null' => true],
            'email' => ['type' => 'varchar', 'constraint' => 100, 'not_null' => true],
            'password_hash' => ['type' => 'varchar', 'constraint' => 255, 'not_null' => true],
            'full_name' => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'created_at' => ['type' => 'timestamp', 'default' => \DB::expr('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'timestamp', 'default' => \DB::expr('CURRENT_TIMESTAMP'), 'on_update' => \DB::expr('CURRENT_TIMESTAMP')],
        ], ['id'], false, 'InnoDB', 'utf8');

        // Thêm unique index cho username và email
        \DBUtil::create_index('users', 'username', 'idx_username', 'UNIQUE');
        \DBUtil::create_index('users', 'email', 'idx_email', 'UNIQUE');
    }

    public function down()
    {
        \DBUtil::drop_table('users');
    }
}
