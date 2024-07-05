<?php

namespace app\controllers;

use yii\web\Controller;

class HelpController extends Controller
{
    public function actionIndex()
    {
        $this->view->title = "О проекте";
        return $this->render('index');
    }
}