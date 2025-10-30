<?php
class Controller_Search extends Controller
{
    public function action_index()
    {
        $query = Input::get('q', '');
        $movies = [];

        if ($query) {
            $movies = Model_Movie::query()
                ->where('title', 'LIKE', '%' . $query . '%')
                ->or_where('title_vnm', 'LIKE', '%' . $query . '%')
                ->order_by('views_count', 'DESC')
                ->limit(20)
                ->get();
        }
        // echo "<pre>"; print_r($movies); echo "</pre>"; die;

        $data = [
            'query' => $query,
            'movies' => $movies,
        ];

        return Service_Layout::render(View::forge('client/movie/search/index', $data));
    }

    public function action_suggest()
    {
        $query = Input::get('q', '');
        $movies = [];

        if ($query) {
            $movies = Model_Movie::query()
                ->where('title', 'LIKE', '%' . $query . '%')
                ->or_where('title_vnm', 'LIKE', '%' . $query . '%')
                ->order_by('views_count', 'DESC')
                ->limit(5)
                ->get();
        }

        $suggestions = [];
        foreach ($movies as $movie) {
            $suggestions[] = [
                'title' => $movie->title_vnm ?: $movie->title,
                'url' => \Uri::create('movie/' . $movie->slug . '-' . sprintf('%06d', $movie->id)),
            ];
        }

        return Response::forge(json_encode($suggestions), 200, ['Content-Type' => 'application/json']);
    }
}
