<?php
class Model_User extends Orm\Model
{
    protected static $_table_name = 'users';
    protected static $_primary_key = ['id'];

    protected static $_properties = [
        'id' => [
            'data_type' => 'int',
            'auto_increment' => true,
        ],
        'username' => [
            'data_type' => 'varchar',
            'validation' => ['required', 'max_length' => 50, 'unique' => 'users.username'],
        ],
        'email' => [
            'data_type' => 'varchar',
            'validation' => ['required', 'max_length' => 100, 'valid_email', 'unique' => 'users.email'],
        ],
        'password_hash' => [
            'data_type' => 'varchar',
            'validation' => ['required', 'max_length' => 255],
        ],
        'full_name' => [
            'data_type' => 'varchar',
            'validation' => ['max_length' => 100],
        ],
        'created_at' => [
            'data_type' => 'timestamp',
            'default' => 'CURRENT_TIMESTAMP',
        ],
        'updated_at' => [
            'data_type' => 'timestamp',
            'default' => 'CURRENT_TIMESTAMP',
        ],
    ];

    protected static $_observers = [
        'Orm\Observer_CreatedAt' => [
            'events' => ['before_insert'],
            'mysql_timestamp' => true,
        ],
        'Orm\Observer_UpdatedAt' => [
            'events' => ['before_update'],
            'mysql_timestamp' => true,
        ],
        'Orm\Observer_Validation' => [
            'events' => ['before_save'],
        ],
    ];

    // Quan hệ: Một user có nhiều ratings
    protected static $_has_many = [
        'ratings' => [
            'model_to' => 'Model_Rating',
            'key_from' => 'id',
            'key_to' => 'user_id',
            'cascade_save' => true,
            'cascade_delete' => true,
        ],
        'comments' => [
            'model_to' => 'Model_Comment',
            'key_from' => 'id',
            'key_to' => 'user_id',
            'cascade_save' => true,
            'cascade_delete' => true,
        ],
    ];
}
