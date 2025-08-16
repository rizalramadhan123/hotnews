<?php

namespace app\models;

use yii\base\Component;

class NewsApi extends Component
{
    // Hardcode API key
    private $apiKey = '8908e1b8c5014a0396d815ded5d06e41';
    public $pageSize = 10;

    public function getArticlesByKeyword($query, $from, $page = 10)
    {
        $url = 'https://newsapi.org/v2/everything?' . http_build_query([
            'q' => $query,
            'from' => $from,
            'sortBy' => 'publishedAt',
            'apiKey' => $this->apiKey,
            'pageSize' => $page,
            'page' => $page,
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0'); 

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return []; // Jika gagal request
        }

        $data = json_decode($response, true);
        return $data['articles'] ?? [];
    }

    public function getArticlesTopTen()
    {
        $url = 'https://newsapi.org/v2/top-headlines?' . http_build_query([
            'sortBy' => 'publishedAt',
            'apiKey' => $this->apiKey,
            'pageSize' => 10,
            'country' => 'us'
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0'); 

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return []; // Jika gagal request
        }

        $data = json_decode($response, true);
        return $data['articles'] ?? [];
    }

    public function getArticlesCategories($category)
    {
        $url = 'https://newsapi.org/v2/top-headlines?' . http_build_query([
            'apiKey' => $this->apiKey,
            'pageSize' => 10,
            'country' => 'us',
            'category' => $category,
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0'); 

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return []; // Jika gagal request
        }

        $data = json_decode($response, true);
        return $data['articles'] ?? [];
    }

}

