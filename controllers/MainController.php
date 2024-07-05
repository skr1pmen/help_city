<?php

namespace app\controllers;

use app\repository\MainRepository;
use yii\web\Controller;

class MainController extends Controller
{
    public function actionIndex()
    {
        $this->view->title = "Главная страница";

        $created = MainRepository::createdApplication();
        $processing = MainRepository::processingApplication();
        $atWork = MainRepository::atWorkApplication();
        $resolved = MainRepository::resolvedApplication();

        return $this->render('index', [
            'created' => $created,
            'processing' => $processing,
            'atWork' => $atWork,
            'resolved' => $resolved,
        ]);
    }
}