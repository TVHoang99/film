<?php

class Model_Movie_Episode extends \Orm\Model
{
    protected static $_table_name = 'movie_episodes';
    protected static $_primary_key = ['id'];

    protected static $_properties = [
        'id' => ['data_type' => 'int', 'auto_increment' => true],
        'movie_id' => ['data_type' => 'int', 'validation' => ['required']],
        'episode_number' => [
            'data_type' => 'varchar',
            'validation' => ['required', 'max_length' => 50],
        ],
        'language' => [
            'data_type' => 'varchar',
            'validation' => ['required', 'in_list' => ['vietsub', 'thuyết minh']],
        ],
        'video_url' => [
            'data_type' => 'text',
            'validation' => ['required'],
        ],
        'created_at' => ['data_type' => 'timestamp', 'default' => 'CURRENT_TIMESTAMP'],
    ];

    protected static $_belongs_to = [
        'movie' => [
            'model_to' => 'Model_Movie',
            'key_from' => 'movie_id',
            'key_to' => 'id',
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
}
