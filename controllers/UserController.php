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
    public function actionRegistration()
    {
        $this->view->title = 'Регистрация';

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $city = CityRepository::getCities();
        $cityList = [];
        foreach ($city as $item) {
            $cityList[$item['id']] = $item['name'];
        }

        $model = new RegistrationForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                var_dump($model);
                $userId = UserRepository::createUser(
                    $model->email,
                    $model->password,
                    $model->name,
                    $model->surname,
                    mt_rand(100000, 999999),
                    CityRepository::getCityId($model->city)
                );
                if ($userId) {
                    Yii::$app->user->login(Users::findIdentity($userId));
                    Yii::$app->session->set('notification', ['status' => true, 'message' => 'Регистрация прошла успешно!']);
                    return $this->goHome();
                }
            }
        }

        return $this->render('registration', ['model' => $model, 'cities' => $cityList]);
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

    public function actionProfile($id = null)
    {
        $this->view->title = "Профиль";
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/user/authorization');
        }
        if ($id != Yii::$app->user->id && !empty($id)) {
            $data = UserRepository::getUserById($id);
            $countApplication = ApplicationRepository::getCountApplicationUser($id);
            return $this->render('profile', ['data' => $data, 'countApplication' => $countApplication]);

        }

        $edit = new UserDataForm();

        $city = CityRepository::getCities();
        $cityList = [];
        foreach ($city as $item) {
            $cityList[$item['id']] = $item['name'];
        }

        if ($edit->load(\Yii::$app->request->post())) {
            $edit->avatar = UploadedFile::getInstance($edit, 'avatar');
            if ($edit->validate()) {
                UserRepository::editDataUser(
                    Yii::$app->user->id,
                    $edit->name,
                    $edit->surname,
                    $edit->city,
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

            if ($verification->load(\Yii::$app->request->post()) && $verification->validate()) {
                UserRepository::verification(Yii::$app->user->id);
                Yii::$app->session->set('notification', ['status' => true, 'message' => 'Верификация успешно прошла!']);
                return $this->redirect('/user/profile');
            }

            return $this->render('profile', ['edit' => $edit, 'cities' => $cityList, 'verification' => $verification]);
        } else {
            $countApplication = ApplicationRepository::getCountApplicationUser(Yii::$app->user->id);

            return $this->render('profile', ['edit' => $edit, 'cities' => $cityList, 'countApplication' => $countApplication]);
        }
    }

    public function actionVerification()
    {
        $code = Yii::$app->user->identity->verification_code;

        Yii::$app->mailer->compose('verification/index', ['code' => $code])
            ->setFrom(['kiberkot.v.roymenge@gmail.com' => 'HelpCity'])
            ->setTo(Yii::$app->user->identity->email)
            ->setSubject('Подтверждение аккаунта HelpCity')
            ->send();

        return $this->render('verification');
    }
}