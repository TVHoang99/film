<?php
return array (
  'version' => array(  
    'app' => array(    
      'default' => array(      
        0 => '001_create_users',
        1 => '002_create_categories',
        2 => '003_create_movies',
        3 => '004_create_movie_categories',
        4 => '005_create_ratings',
        5 => '006_create_comments',
        6 => '007_add_slug_to_movies',
        7 => '008_update_slugs_for_movies',
        8 => '009_change_video_url_to_text_in_movies',
        9 => '010_add_director_actors_status_language_to_movies',
        10 => '011_change_status_language_to_varchar_in_movies',
        11 => '012_add_hashtag_to_movies',
        12 => '013_add_title_vnm_to_movies',
        13 => '014_add_episode_to_movies',
        14 => '015_create_movie_episodes',
        15 => '016_remove_language_episode_video_url_from_movies',
        16 => '017_add_banner_url_to_movies',
        17 => '018_create_admins',
        18 => '019_add_parent_id_to_comments',
      ),
    ),
    'module' => array(    
    ),
    'package' => array(    
    ),
  ),
  'folder' => 'migrations/',
  'table' => 'migration',
  'flush_cache' => false,
  'flag' => NULL,
);
