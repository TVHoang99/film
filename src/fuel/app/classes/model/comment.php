<?php
class Model_Comment extends Orm\Model
{
    protected static $_table_name = 'comments';
    protected static $_primary_key = ['id'];

    protected static $_properties = [
        'id' => [
            'data_type' => 'int',
            'auto_increment' => true,
        ],
        'user_id' => [
            'data_type' => 'int',
            'validation' => ['required'],
        ],
        'movie_id' => [
            'data_type' => 'int',
            'validation' => ['required'],
        ],
        'comment' => [
            'data_type' => 'text',
            'validation' => ['required'],
        ],
        'parent_id' => [
            'data_type' => 'int',
        ],
        'created_at' => [
            'data_type' => 'timestamp',
            'default' => 'CURRENT_TIMESTAMP',
        ],
    ];

    protected static $_observers = [
        'Orm\Observer_CreatedAt' => [
            'events' => ['before_insert'],
            'mysql_timestamp' => true,
        ],
        // 'Orm\Observer_Validation' => [
        //     'events' => ['before_save'],
        // ],
    ];

    protected static $_belongs_to = [
        'user' => [
            'model_to' => 'Model_User',
            'key_from' => 'user_id',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => true,
        ],
        'movie' => [
            'model_to' => 'Model_Movie',
            'key_from' => 'movie_id',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => true,
        ],
    ];

    protected static $_has_many = [
        'replies' => [
            'model_to' => 'Model_Comment',
            'key_from' => 'id',
            'key_to' => 'parent_id',
            'cascade_save' => true,
            'cascade_delete' => false,
        ]
    ];
}
