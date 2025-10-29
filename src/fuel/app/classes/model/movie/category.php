<?php
class Model_Movie_Category extends Orm\Model
{
    protected static $_table_name = 'movie_categories';
    protected static $_primary_key = ['movie_id', 'category_id'];

    protected static $_properties = [
        'movie_id' => [
            'data_type' => 'int',
            'validation' => ['required'],
        ],
        'category_id' => [
            'data_type' => 'int',
            'validation' => ['required'],
        ],
    ];

    protected static $_belongs_to = [
        'movie' => [
            'model_to' => 'Model_Movie',
            'key_from' => 'movie_id',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => true,
        ],
        'category' => [
            'model_to' => 'Model_Category',
            'key_from' => 'category_id',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => true,
        ],
    ];
}
