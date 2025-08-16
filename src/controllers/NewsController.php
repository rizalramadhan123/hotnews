<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\NewsApi;
use yii\web\Request;

class NewsController extends Controller
{
    public function actionIndex()
    {
        $newsApi = new NewsApi();
        $articles = $newsApi->getArticlesTopTen();
        $categories = [
            'business' => 'Bisnis',
            'entertainment' => 'Hiburan',
            'general' => 'Umum',
            'health' => 'Kesehatan',
            'science' => 'Sains',
            'sports' => 'Olahraga',
            'technology' => 'Teknologi',
        ];

        return $this->render('index', [
            'articles' => $articles,
            'categories' => $categories,
        ]);
    }
    public function actionSearch(){
        $req = Yii::$app->request;
        $q = $req->post('q');
        $category = $req->post('category');
        $newsApi = new NewsApi();
        if($q != ''){
            $tanggal = date('d-m-Y');
            $data = $newsApi->getArticlesByKeyword($q,$tanggal,10);
        }else if($category != ''){
            $data = $newsApi->getArticlesCategories($category);
        }else{
            $data = [];
        }

        echo json_encode($data);
        die();
    }
}

