<?php

namespace app\controllers;

use app\entity\Users;
use app\models\AuthorizationForm;
use app\models\RegistrationForm;
use app\models\UserDataForm;
use app\models\VerificationForm;
use app\repository\ApplicationRepository;
use app\repository\UserRepository;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;

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
                    $code = mt_rand(100000, 999999)
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

    public function actionProfile($id = 0)
    {
        $this->view->title = "Профиль";
        if (Yii::$app->user->isGuest) {
            return $this->redirect('user/authorization');
        }
        if ($id === 0) $id = \Yii::$app->user->id;
        $edit = new UserDataForm();

        if ($edit->load(\Yii::$app->request->post())) {
            $edit->avatar = UploadedFile::getInstance($edit, 'avatar');
            if ($edit->validate()) {
                UserRepository::editDataUser(
                    Yii::$app->user->id,
                    $edit->name,
                    $edit->surname
                );
                if (!empty($edit->avatar)) {
                    $file = Yii::$app->user->id . '.jpg';
                    $edit->avatar->saveAs("images/user_avatar/$file");
                }
                Yii::$app->session->set('notification', ['status' => true, 'message' => 'Данные успешно изменены!']);
            }
        }

        $code = Yii::$app->user->identity->verification_code;

        if (!empty($code)) {
            $verification = new VerificationForm();

            Yii::$app->mailer->compose('verification/index', ['code' => $code])
                ->setFrom(['kiberkot.v.roymenge@gmail.com' => 'HelpCity'])
                ->setTo(Yii::$app->user->identity->email)
                ->setSubject('Подтверждение аккаунта HelpCity')
                ->send();

            if ($verification->load(\Yii::$app->request->post()) && $verification->validate()) {
                UserRepository::verification(Yii::$app->user->id);
                Yii::$app->session->set('notification', ['status' => true, 'message' => 'Верификация успешно прошла!']);
                return $this->redirect('/user/profile');
            }

            return $this->render('profile', ['edit' => $edit, 'verification' => $verification]);
        } else {
            $countApplication = ApplicationRepository::getCountApplicationUser(Yii::$app->user->id);

            return $this->render('profile', ['edit' => $edit, 'countApplication' => $countApplication]);
        }
    }
}