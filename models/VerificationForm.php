<?php

namespace app\models;

use Yii;
use yii\base\Model;

class VerificationForm extends Model
{
    // Создание полей для формы
    public $code;


    public function rules() // Правила валидации полей
    {
        return [
            ['code', 'required'],
            ['code', 'string', 'length' => [6, 6]],
            ['code', 'validateCode'],
        ];
    }

    public function validateCode($attribute, $params) // Валидация кода верификации
    {
        if (!$this->hasErrors()) { // Проверка на ошибки
            if (Yii::$app->user->identity->verification_code != $this->code) { // Проверка на совпадение кодов
                Yii::$app->session->set('notification', ['status' => false, 'message' => 'Неверный код']); // Создание уведомления
                $this->addError($attribute, "Неверный код"); // Создание ошибки
            }
        }
    }

    public function attributeLabels()  // Псевдонимы для полей
    {
        return [
            'code' => 'Ваш код'
        ];
    }
}