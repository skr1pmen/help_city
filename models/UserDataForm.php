<?php

namespace app\models;

use yii\base\Model;

class UserDataForm extends Model
{
    public $name;
    public $surname;

    public function rules()
    {
        return [
            [['name', 'surname'], 'required'],
            [['name', 'surname'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Введите имя',
            'surname' => 'Введите фамилию',
        ];
    }
}