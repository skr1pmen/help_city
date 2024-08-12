<?php

namespace app\controllers;

use app\models\CreateApplicationForm;
use app\models\EditApplicationForm;
use app\repository\ApplicationRepository;
use app\repository\CityRepository;
use app\repository\StatusRepository;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;

class ApplicationController extends Controller
{
    public function actionIndex($from_user = null, $city = null) // Обработчик стартовой страницы заявок
    {
        if (Yii::$app->user->isGuest) { // Проверка пользователя на авторизацию
            return $this->redirect('/user/authorization'); // Если пользователь гость, то перевод на страницу авторизации
        }

        $this->view->title = "Страница заявок"; // Выдача заголовка для страницы
        if (empty($city)) { // Проверка get параметра на пустоту
            $city = Yii::$app->user->identity->city_id; // Если пустое, то выдаётся такое же значение как у пользователя
        }

        $applications = ApplicationRepository::getAllApplication($from_user, $city); // Получение всех заявок для отображения

        return $this->render('index', ['applications' => $applications]); // Возвращение страницы с передачей всех заявок
    }

    public function actionCreate() // Обработка страницы создание заявки
    {
        $this->view->title = "Создание заявки"; // Выдача заголовка для страницы

        $model = new CreateApplicationForm(); // Создание модели для формы создания заявки
        if ($model->load(Yii::$app->request->post())) { // проверяем форму за загрузку и ти получения данных
            $model->photo_1 = UploadedFile::getInstance($model, 'photo_1'); // Обработка всех фотографий полученных в форме
            $model->photo_2 = UploadedFile::getInstance($model, 'photo_2');
            $model->photo_3 = UploadedFile::getInstance($model, 'photo_3');
            $model->photo_4 = UploadedFile::getInstance($model, 'photo_4');
            if ($model->validate()) { // Проверка на валидацию формы
                $appId = ApplicationRepository::create( // Создание новой заявки
                    $model->title,
                    $model->description,
                    $model->address,
                    Yii::$app->user->identity->id,
                    Yii::$app->user->identity->city_id
                );
                if ($appId) { // Проверка на получение id новой заявки. Если он есть, то
                    mkdir('images/applications/' . $appId); // Создание новой папки для файлов заявки
                    if (file_exists('images/applications/' . $appId)) { // Проверка на наличие нужной папки
                        if (!empty($model->photo_1)) { // Проверка на наличие фотографии в форме
                            $file = $appId . '_1.jpg'; // Если есть, то Создаем название для файла
                            $model->photo_1->saveAs("images/applications/$appId/$file"); // Сохранение файла в папке заявки
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
                ]; // Создание дополнительных параметров для запроса к сервису Yandex Geocoder https://yandex.ru/maps-api/products/geocoder-api
                $ch = curl_init('https://geocode-maps.yandex.ru/1.x?' . http_build_query($params)); // Формирование и отправка запроса к сервису
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HEADER, false);
                $html = json_decode(curl_exec($ch));
                curl_close($ch);
                $coordinate = str_replace(' ', ',', $html->response->GeoObjectCollection->featureMember[0]->GeoObject->Point->pos); // Получение и обработка полученных данных

                $params = [
                    'apikey' => Yii::$app->params['apikeyStaticMap'],
                    'll' => $coordinate,
                    'z' => 19
                ]; // Создание дополнительных параметров для запроса к сервису Yandex Static https://yandex.ru/maps-api/products/static-api
                $ch = curl_init('https://static-maps.yandex.ru/v1?' . http_build_query($params)); // Формирование и отправка запроса к сервису
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HEADER, false);
                $html = curl_exec($ch);
                curl_close($ch);
                if (!empty($html)) { // Проверка на получение данных
                    file_put_contents("images/applications/$appId/map.png", $html); // Если всё хорошо, то сохраняем полученный файл в папку с заявкой
                }

                Yii::$app->session->set('notification', ['status' => true, 'message' => 'Запись успешно создана!']); // Создание уведомления
                return $this->redirect('/application/index'); // Перевод пользователя на страницу всех заявок
            }
        }

        return $this->render('create', ['model' => $model]); // Возвращение страницы с передачей формы для создания заявки
    }

    public function actionApp($id) // Обработчик страницы заявки
    {
        $app = ApplicationRepository::getApplication($id); // Получение данных о заявке из бд
        $this->view->title = $app->title; // Выдача заголовка равной названию заявки
        $status = StatusRepository::getStatus($app->status_id); // Получение статуса заявки

        return $this->render('app', ['app' => $app, 'status' => $status]); // Возврат страницы заявки со всеми нужными данными
    }

    public function actionEdit($id) // Обработка страницы редактирования заявки
    {
        $app = ApplicationRepository::getApplication($id); // Получение старых данных заявки
        $this->view->title = $app->title; // Выдача заголовка равной названию заявки
        $model = new EditApplicationForm(); // Создание формы редактирование

        if ($model->load(Yii::$app->request->post())) {  // проверка за загруженность и правильность типа данных формы
            $model->photo_1 = UploadedFile::getInstance($model, 'photo_1'); // Получение всех фотографий из формы
            $model->photo_2 = UploadedFile::getInstance($model, 'photo_2');
            $model->photo_3 = UploadedFile::getInstance($model, 'photo_3');
            $model->photo_4 = UploadedFile::getInstance($model, 'photo_4');
            if ($model->validate()) { // Проверка на валидацию формы
                ApplicationRepository::edit( // Изменение заявки
                    $app->id,
                    $model->title,
                    $model->description,
                    $model->address
                );
                if (!empty($model->photo_1)) { // Проверка на наличие фотографии в форме
                    $file = $app->id . '_1.jpg'; // Выдача названия фотографии
                    $model->photo_1->saveAs("images/applications/$app->id/$file"); // Сохранение фотографии в папке с заявкой
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
                ]; // Создание дополнительных параметров для запроса к сервису Yandex Geocoder https://yandex.ru/maps-api/products/geocoder-api
                $ch = curl_init('https://geocode-maps.yandex.ru/1.x?' . http_build_query($params)); // Формирование и отправка запроса к сервису
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HEADER, false);
                $html = json_decode(curl_exec($ch));
                curl_close($ch);
                $coordinate = str_replace(' ', ',', $html->response->GeoObjectCollection->featureMember[0]->GeoObject->Point->pos); // Получение и обработка полученных данных

                $params = [
                    'apikey' => Yii::$app->params['apikeyStaticMap'],
                    'll' => $coordinate,
                    'z' => 19
                ]; // Создание дополнительных параметров для запроса к сервису Yandex Static https://yandex.ru/maps-api/products/static-api
                $ch = curl_init('https://static-maps.yandex.ru/v1?' . http_build_query($params)); // Формирование и отправка запроса к сервису
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HEADER, false);
                $html = curl_exec($ch);
                curl_close($ch);
                if (!empty($html)) {  // Проверка на получение данных
                    file_put_contents("images/applications/$app->id/map.png", $html); // Если всё хорошо, то сохраняем полученный файл в папку с заявкой
                }

                Yii::$app->session->set('notification', ['status' => true, 'message' => 'Запись успешно создана!']);  // Создание уведомления
                return $this->redirect("/application/app?id=" . $app->id); // Перевод пользователя на страницу заявки
            }
        }

        return $this->render('edit', ['data' => $app, 'model' => $model]); // Возврат страницы редактирования заявки с формой
    }

    public function actionDelete($id) // Обработка страницы удаления заявки
    {
        ApplicationRepository::delete($id); // Запрос на удаление заявки

        return $this->redirect('/application/index'); // Возврат пользователя на страницу всех заявок
    }
}