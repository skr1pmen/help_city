<?php

namespace app\modules\admin\controllers;

use app\modules\admin\repository\AdminRepository;
use yii\filters\AccessControl;
use yii\web\Controller;

class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    return $this->redirect('/');
                }
            ]
        ];
    }
    public function actionIndex()
    {
        $this->view->title = 'Админ панель';

        $stats = [];
        $stats['all'] = AdminRepository::getCountAllApp();
        $stats['created'] = AdminRepository::getCountCreatedApp();
        $stats['process'] = AdminRepository::getCountProcessApp();
        $stats['work'] = AdminRepository::getCountWorkApp();
        $stats['finish'] = AdminRepository::getCountFinishedApp();

        return $this->render('index', ['stats' => $stats]);
    }
}