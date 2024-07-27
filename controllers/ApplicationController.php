<?php

namespace app\controllers;

use app\models\CreateApplicationForm;
use app\models\EditApplicationForm;
use app\repository\ApplicationRepository;
use app\repository\CityRepository;
use app\repository\StatusRepository;
use Yii;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\UploadedFile;

class ApplicationController extends Controller
{
    public function actionIndex($from_user = null)
    {
        $this->view->title = "Страница заявок";

        $applications = ApplicationRepository::getAllApplication($from_user);

        return $this->render('index', ['applications' => $applications]);
    }

    public function actionCreate()
    {
        $this->view->title = "Создание заявки";

        $model = new CreateApplicationForm();
        if ($model->load(Yii::$app->request->post())) {
            $model->photo_1 = UploadedFile::getInstance($model, 'photo_1');
            $model->photo_2 = UploadedFile::getInstance($model, 'photo_2');
            $model->photo_3 = UploadedFile::getInstance($model, 'photo_3');
            $model->photo_4 = UploadedFile::getInstance($model, 'photo_4');
            if ($model->validate()) {
                $appId = ApplicationRepository::create(
                    $model->title,
                    $model->description,
                    $model->address,
                    Yii::$app->user->identity->id,
                    Yii::$app->user->identity->city_id
                );
                if ($appId) {
                    mkdir('images/applications/' . $appId);
                    if (file_exists('images/applications/' . $appId)) {
                        if (!empty($model->photo_1)) {
                            $file = $appId . '_1.jpg';
                            $model->photo_1->saveAs("images/applications/$appId/$file");
                        }
                        if (!empty($model->photo_2)) {
                            $file = $appId . '_2.jpg';
                            $model->photo_2->saveAs("images/applications/$appId/$file");
                        }
                        if (!empty($model->photo_3)) {
                            $file = $appId . '_3.jpg';
                            $model->photo_3->saveAs("images/applications/$appId/$file");
                        }
                        if (!empty($model->photo_4)) {
                            $file = $appId . '_4.jpg';
                            $model->photo_4->saveAs("images/applications/$appId/$file");
                        }
                    }
                }
                $params = [
                    'lang' => 'ru_RU',
                    'format' => 'json',
                    'apikey' => Yii::$app->params['apikeyGeocoder'],
                    'geocode' => CityRepository::getCityById(Yii::$app->user->identity->city_id) . ' ' . $model->address
                ];
                $ch = curl_init('https://geocode-maps.yandex.ru/1.x?' . http_build_query($params));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HEADER, false);
                $html = json_decode(curl_exec($ch));
                curl_close($ch);
                $coordinate = str_replace(' ', ',', $html->response->GeoObjectCollection->featureMember[0]->GeoObject->Point->pos);

                $params = [
                    'apikey' => Yii::$app->params['apikeyStaticMap'],
                    'll' => $coordinate,
                    'z' => 19
                ];
                $ch = curl_init('https://static-maps.yandex.ru/v1?' . http_build_query($params));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HEADER, false);
                $html = curl_exec($ch);
                curl_close($ch);
                if (!empty($html)) {
                    file_put_contents("images/applications/$appId/map.png", $html);
                }

                Yii::$app->session->set('notification', ['status' => true, 'message' => 'Запись успешно создана!']);
                return $this->redirect('/application/index');
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionApp($id)
    {
        $app = ApplicationRepository::getApplication($id);
        $this->view->title = $app->title;
        $status = StatusRepository::getStatus($app->status_id);

        return $this->render('app', ['app' => $app, 'status' => $status]);
    }

    public function actionEdit($id)
    {
        $app = ApplicationRepository::getApplication($id);
        $this->view->title = $app->title;
        $model = new EditApplicationForm();

        if ($model->load(Yii::$app->request->post())) {
            $model->photo_1 = UploadedFile::getInstance($model, 'photo_1');
            $model->photo_2 = UploadedFile::getInstance($model, 'photo_2');
            $model->photo_3 = UploadedFile::getInstance($model, 'photo_3');
            $model->photo_4 = UploadedFile::getInstance($model, 'photo_4');
            if ($model->validate()) {
                ApplicationRepository::edit(
                    $app->id,
                    $model->title,
                    $model->description,
                    $model->address
                );
                if (!empty($model->photo_1)) {
                    $file = $app->id . '_1.jpg';
                    $model->photo_1->saveAs("images/applications/$app->id/$file");
                }
                if (!empty($model->photo_2)) {
                    $file = $app->id . '_2.jpg';
                    $model->photo_2->saveAs("images/applications/$app->id/$file");
                }
                if (!empty($model->photo_3)) {
                    $file = $app->id . '_3.jpg';
                    $model->photo_3->saveAs("images/applications/$app->id/$file");
                }
                if (!empty($model->photo_4)) {
                    $file = $app->id . '_4.jpg';
                    $model->photo_4->saveAs("images/applications/$app->id/$file");
                }
                $params = [
                    'lang' => 'ru_RU',
                    'format' => 'json',
                    'apikey' => Yii::$app->params['apikeyGeocoder'],
                    'geocode' => CityRepository::getCityById(Yii::$app->user->identity->city_id) . ' ' . $model->address
                ];
                $ch = curl_init('https://geocode-maps.yandex.ru/1.x?' . http_build_query($params));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HEADER, false);
                $html = json_decode(curl_exec($ch));
                curl_close($ch);
                $coordinate = str_replace(' ', ',', $html->response->GeoObjectCollection->featureMember[0]->GeoObject->Point->pos);

                $params = [
                    'apikey' => Yii::$app->params['apikeyStaticMap'],
                    'll' => $coordinate,
                    'z' => 19
                ];
                $ch = curl_init('https://static-maps.yandex.ru/v1?' . http_build_query($params));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HEADER, false);
                $html = curl_exec($ch);
                curl_close($ch);
                if (!empty($html)) {
                    file_put_contents("images/applications/$app->id/map.png", $html);
                }

                Yii::$app->session->set('notification', ['status' => true, 'message' => 'Запись успешно создана!']);
                return $this->redirect("/application/app?id=" . $app->id);
            }
        }

        return $this->render('edit', ['data' => $app, 'model' => $model]);
    }

    public function actionDelete($id)
    {
        ApplicationRepository::delete($id);
        FileHelper::removeDirectory("images/applications/$id");

        return $this->redirect('/application/index');
    }
}