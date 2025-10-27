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
