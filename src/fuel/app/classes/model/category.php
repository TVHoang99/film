<?php
class Model_Category extends Orm\Model
{
    protected static $_table_name = 'categories';
    protected static $_primary_key = ['id'];

    protected static $_properties = [
        'id' => [
            'data_type' => 'int',
            'auto_increment' => true,
        ],
        'name' => [
            'data_type' => 'varchar',
            'validation' => ['required', 'max_length' => 100, 'unique' => 'categories.name'],
        ],
        'description' => [
            'data_type' => 'text',
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

    // Quan hệ: Một danh mục có nhiều phim (many-to-many qua movie_categories)
    protected static $_many_many = [
        'movies' => [
            'model_to' => 'Model_Movie',
            'key_from' => 'id',
            'key_to' => 'id',
            'table_through' => 'movie_categories',
            'key_through_from' => 'category_id',
            'key_through_to' => 'movie_id',
            'cascade_save' => true,
            'cascade_delete' => true,
        ],
    ];

    public static function validate($factory)
    {
        $val = \Validation::forge($factory);
        $val->add_field('name', 'Name', 'required|max_length[100]');
        $val->add_field('description', 'Description', 'required|max_length[500]');
        return $val;
    }
}
