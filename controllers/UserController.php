<?php

namespace app\controllers;

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
            $model->photo = UploadedFile::getInstance($model, 'photo');
            if ($model->validate()) {
                $userId = UserRepository::createUser(
                    $model->login,
                    $model->password,
                    $model->name,
                    $model->surname,
                    $model->patronymic,
                );
                if (!empty($model->photo)) {
                    $file = $userId . '.' . $model->photo->extension;
                    $model->photo->saveAs("images/users_avatars/$file");
                }
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

        $model = new AuthorisationForm();
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        }
        return $this->render('authorization', ['model' => $model]);
    }
}