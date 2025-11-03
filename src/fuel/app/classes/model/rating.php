<?php
class Model_Rating extends Orm\Model
{
    protected static $_table_name = 'ratings';
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
        'rating' => [
            'data_type' => 'int',
            'validation' => ['required', 'numeric_min' => 1, 'numeric_max' => 5],
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
}
