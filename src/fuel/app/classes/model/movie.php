<?php
class Model_Movie extends Orm\Model
{
    protected static $_table_name = 'movies';
    protected static $_primary_key = ['id'];

    protected static $_properties = [
        'id' => [
            'data_type' => 'int',
            'auto_increment' => true,
        ],
        'title' => [
            'data_type' => 'varchar',
            'validation' => ['required', 'max_length' => 255],
        ],
        'slug' => [
            'data_type' => 'varchar',
            'validation' => ['required', 'max_length' => 255, 'unique' => 'movies.slug', 'match_pattern' => '/^[a-z0-9-]+$/'],
        ],
        'imdb_rating' => [
            'data_type' => 'decimal',
            'validation' => ['numeric_min' => 0, 'numeric_max' => 10],
        ],
        'duration' => [
            'data_type' => 'int',
        ],
        'release_date' => [
            'data_type' => 'date',
        ],
        'summary' => [
            'data_type' => 'text',
        ],
        'poster_url' => [
            'data_type' => 'varchar',
            'validation' => ['max_length' => 255],
        ],
        'video_url' => [
            'data_type' => 'varchar',
            'validation' => ['max_length' => 255],
        ],
        'is_featured' => [
            'data_type' => 'tinyint',
            'default' => 0,
        ],
        'views_count' => [
            'data_type' => 'int',
            'default' => 0,
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
        // 'Orm\Observer_Validation' => [
        //     'events' => ['before_save'],
        // ],
    ];

    protected static $_many_many = [
        'categories' => [
            'model_to' => 'Model_Category',
            'key_from' => 'id',
            'key_to' => 'id',
            'table_through' => 'movie_categories',
            'key_through_from' => 'movie_id',
            'key_through_to' => 'category_id',
            'cascade_save' => true,
            'cascade_delete' => true,
        ],
    ];

    protected static $_has_many = [
        'ratings' => [
            'model_to' => 'Model_Rating',
            'key_from' => 'id',
            'key_to' => 'movie_id',
            'cascade_save' => true,
            'cascade_delete' => true,
        ],
        'comments' => [
            'model_to' => 'Model_Comment',
            'key_from' => 'id',
            'key_to' => 'movie_id',
            'cascade_save' => true,
            'cascade_delete' => true,
        ],
    ];

    // Phương thức: Tính trung bình đánh giá
    public function average_rating()
    {
        $ratings = $this->ratings;
        if (empty($ratings)) {
            return 0;
        }
        $sum = array_sum(array_column($ratings, 'rating'));
        return round($sum / count($ratings), 1);
    }

    // Phương thức: Đếm số lượt đánh giá
    public function rating_count()
    {
        return count($this->ratings);
    }

    // Phương thức: Tạo slug từ title
    public static function generate_slug($title)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        // Đảm bảo slug là duy nhất
        $count = static::query()->where('slug', 'like', $slug . '%')->count();
        return $count > 0 ? $slug . '-' . $count : $slug;
    }
}
