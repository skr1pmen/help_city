<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;

class AdminController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}