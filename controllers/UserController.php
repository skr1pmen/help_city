<?php

namespace app\controllers;

use app\entity\Users;
use app\models\AuthorizationForm;
use app\models\RegistrationForm;
use app\models\UserDataForm;
use app\models\VerificationForm;
use app\repository\ApplicationRepository;
use app\repository\CityRepository;
use app\repository\UserRepository;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;

class UserController extends Controller
{
    public function actionRegistration() // Страница регистрации
    {
        $this->view->title = 'Регистрация'; // Заголовок страницы

        if (!\Yii::$app->user->isGuest) { // Проверка на авторизацию
            return $this->goHome(); // Если есть, то переадресация на главную страницу
        }
        $city = CityRepository::getCities(); // Получение всех городов
        $cityList = []; // Формирование списка городов
        foreach ($city as $item) { // Перебор городов
            $cityList[$item['id']] = $item['name']; // Добавление города в список городов
        }

        $model = new RegistrationForm(); // Создание формы регистрации
        if ($model->load(Yii::$app->request->post())) { // Проверка на загрузку формы и тип получаемых данных
            if ($model->validate()) { // Проверка на вылидацию
                $userId = UserRepository::createUser(
                    $model->email,
                    $model->password,
                    $model->name,
                    $model->surname,
                    mt_rand(100000, 999999),
                    CityRepository::getCityId($model->city)
                ); // Создание нового пользователя
                if ($userId) { // Проверка на наличие id пользователя
                    Yii::$app->user->login(Users::findIdentity($userId)); // Авторизуем пользователя
                    Yii::$app->session->set('notification', ['status' => true, 'message' => 'Регистрация прошла успешно!']); // Создание уведомления
                    return $this->goHome(); // Переадресация на главную
                }
            }
        }

        return $this->render('registration', ['model' => $model, 'cities' => $cityList]); // Вывод страницы регистрации
    }

    public function actionLogout() // Страница выхода из аккаунта
    {
        Yii::$app->user->logout(); // Выход из аккаунта

        return $this->goHome(); // Переадресация на главную
    }

    public function actionAuthorization() // Страница авторизации
    {
        $this->view->title = 'Авторизация'; // заголовок страницы
        if (!\Yii::$app->user->isGuest) { // Проверка на гостя
            return $this->goHome(); // Если гость, то переадресация на главную
        }

        $model = new AuthorizationForm(); // Создание формы для авторизации
        if ($model->load(\Yii::$app->request->post()) && $model->login()) { // Проверка на загрузку формы, тип получаемых данных и авторизацию пользователя
            return $this->goHome(); // Переадресация на главную
        }
        return $this->render('authorization', ['model' => $model]); // Отображение страницы
    }

    public function actionProfile($id = null) // Страница профиля
    {
        $this->view->title = "Профиль"; // Заголовок страницы
        if (Yii::$app->user->isGuest) { // Проверка на гостя
            return $this->redirect('/user/authorization'); // Если гость, то переадресация на авторизацию
        }
        if ($id != Yii::$app->user->id && !empty($id)) { // Проверка на наличие id
            $data = UserRepository::getUserById($id); // Получение данных о пользователе
            $countApplication = ApplicationRepository::getCountApplicationUser($id); // Получение количества заявок от пользователя
            return $this->render('profile', ['data' => $data, 'countApplication' => $countApplication]); // Возврат страницы пользователя

        }

        $edit = new UserDataForm(); // Форма для редактирования данных пользователя

        $city = CityRepository::getCities(); //Получение всех городов
        $cityList = []; // Создание списка городов
        foreach ($city as $item) { // Перебор всех городов
            $cityList[$item['id']] = $item['name']; // Формирование списка городов
        }

        if ($edit->load(\Yii::$app->request->post())) { // Проверка формы на загрузку и тип получаемых данных
            $edit->avatar = UploadedFile::getInstance($edit, 'avatar'); // Получение аватарки из формы
            if ($edit->validate()) { // Проверка на валидацию формы
                UserRepository::editDataUser(
                    Yii::$app->user->id,
                    $edit->name,
                    $edit->surname,
                    $edit->city,
                ); // Изменение данных пользователя
                if (!empty($edit->avatar)) { // Проверка на наличие аватарки в форме
                    $file = Yii::$app->user->id . '.jpg'; // Выдача аватарке имя
                    $edit->avatar->saveAs("images/user_avatar/$file"); // Сохранение фотографии
                }
                Yii::$app->session->set('notification', ['status' => true, 'message' => 'Данные успешно изменены!']); // Создание уведомления
            }
        }

        $code = Yii::$app->user->identity->verification_code; // Получение кода верификации

        if (!empty($code)) { // Если код есть
            $verification = new VerificationForm(); // Создание формы верификации

            if ($verification->load(\Yii::$app->request->post()) && $verification->validate()) { // Проверка на загрузку, тип данных и валидацию формы
                UserRepository::verification(Yii::$app->user->id); // Сохранение верификации
                Yii::$app->session->set('notification', ['status' => true, 'message' => 'Верификация успешно прошла!']); // Создание уведомления
                return $this->redirect('/user/profile'); // Переадресация на профиль
            }

            return $this->render('profile', ['edit' => $edit, 'cities' => $cityList, 'verification' => $verification]); // Отображение профиля
        } else {
            $countApplication = ApplicationRepository::getCountApplicationUser(Yii::$app->user->id); // Получения количества заявок от пользователя

            return $this->render('profile', ['edit' => $edit, 'cities' => $cityList, 'countApplication' => $countApplication]); // Отображение профиля
        }
    }

    public function actionVerification() // Страница верификации
    {
        $code = Yii::$app->user->identity->verification_code; // Получение кода верификации

        Yii::$app->mailer->compose('verification/index', ['code' => $code])
            ->setFrom(['kiberkot.v.roymenge@gmail.com' => 'HelpCity'])
            ->setTo(Yii::$app->user->identity->email)
            ->setSubject('Подтверждение аккаунта HelpCity')
            ->send(); // Отправка письма на почту

        return $this->render('verification'); // Отображение страницы
    }
}