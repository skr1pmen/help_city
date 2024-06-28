<?php

namespace app\controllers;

use app\entity\Users;
use app\models\AuthorizationForm;
use app\models\RegistrationForm;
use app\repository\UserRepository;
use Yii;
use yii\web\Controller;

class UserController extends Controller
{
    public function actionRegistration()
    {
        $this->view->title = 'Регистрация';

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegistrationForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $userId = UserRepository::createUser(
                    $model->email,
                    $model->password,
                    $model->name,
                    $model->surname,
                );
                if ($userId) {
                    Yii::$app->user->login(Users::findIdentity($userId));
                    return $this->goHome();
                }
            }
        }

        return $this->render('registration', ['model' => $model]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionAuthorization()
    {
        $this->view->title = 'Авторизация';
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new AuthorizationForm();
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        }
        return $this->render('authorization', ['model' => $model]);
    }

    public function actionProfile($id)
    {
        return $this->render('profile');
    }
}