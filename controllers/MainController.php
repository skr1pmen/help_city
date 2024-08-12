<?php

namespace app\controllers;

use app\repository\MainRepository;
use yii\web\Controller;

class MainController extends Controller
{
    public function actionIndex() // Обработка главной страницы
    {
        $this->view->title = "Главная страница"; // Выдача заголовка страницы

        $created = MainRepository::createdApplication(); // Получение созданных заявок
        $processing = MainRepository::processingApplication(); // Получение заявок в процессе
        $atWork = MainRepository::atWorkApplication(); // Получение заявок в работе
        $resolved = MainRepository::resolvedApplication(); // Получение завершённых заявок

        return $this->render('index', [
            'created' => $created,
            'processing' => $processing,
            'atWork' => $atWork,
            'resolved' => $resolved,
        ]); // Возврат страницы с нужными данными
    }
}