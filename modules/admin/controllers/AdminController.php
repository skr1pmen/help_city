<?php

namespace app\modules\admin\controllers;

use app\modules\admin\repository\AdminRepository;
use app\modules\admin\repository\AppRepository;
use app\repository\CityRepository;
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
        $this->view->title = 'Админ панель'; // Выдача заголовка страницы

        $stats = []; // Создание массива для сохранения статистики по заявкам
        $stats['all'] = AdminRepository::getCountAllApp(); // Получение количества всех заявок
        $stats['created'] = AdminRepository::getCountCreatedApp(); // Получение количества созданных заявок
        $stats['process'] = AdminRepository::getCountProcessApp(); // Получение количества заявок в обработке
        $stats['work'] = AdminRepository::getCountWorkApp(); // Получение количества заявок в работе
        $stats['finish'] = AdminRepository::getCountFinishedApp(); // Получение количества завершённых заявок

        $applications = AdminRepository::getApp(); // Получение всех заявок
        $statuses = AdminRepository::getStatuses(); // Получение всех статусов заявок
        $statusesList = []; // Преобразование статусов в обычный массив
        foreach ($statuses as $status) {
            $statusesList[$status['id']] = $status['name'];
        }

        $city = CityRepository::getCities(); //Получение всех городов
        $cityList = []; // Создание списка городов
        foreach ($city as $item) { // Перебор всех городов
            $cityList[$item['id']] = $item['name']; // Формирование списка городов
        }

        return $this->render('index',
            [
                'stats' => $stats,
                'applications' => $applications,
                'statuses' => $statusesList,
                'cityList' => $cityList,
            ]
        ); // Выдача страницы на рендер с передачей Статистики, Заявок, Статусов и Городов
    }
}