<?php

namespace app\models;

use Yii;
use yii\base\Model;

class VerificationForm extends Model
{
    public $code;


    public function rules()
    {
        return [
            ['code', 'required'],
            ['code', 'string', 'length' => [6, 6]],
            ['code', 'validateCode'],
        ];
    }

    public function validateCode($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (Yii::$app->user->identity->verification_code != $this->code) {
                Yii::$app->session->set('notification', ['status' => false, 'message' => 'Неверный код']);
                $this->addError($attribute, "Неверный код");
            }
        }
    }

    public function attributeLabels()
    {
        return [
            'code' => 'Ваш код'
        ];
    }
}