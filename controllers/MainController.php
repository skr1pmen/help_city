<?php

namespace app\controllers;

use yii\web\Controller;

class MainController extends Controller
{
    public function actionIndex()
    {
        $this->view->title = "Главная страница";
        return $this->render('index');
    }
}