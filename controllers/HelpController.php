<?php

namespace app\controllers;

use yii\web\Controller;

class HelpController extends Controller
{
    public function actionIndex() // Обработка страницы помощи
    {
        $this->view->title = "О проекте"; // Выдача заголовка для страницы
        return $this->render('index'); // Выдача страницы помощи
    }
}