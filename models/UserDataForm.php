<?php

namespace app\models;

use yii\base\Model;

class UserDataForm extends Model
{
    public $avatar;
    public $name;
    public $surname;
    public $city;

    public function rules()
    {
        return [
            [['name', 'surname', 'city'], 'required'],
            [['name', 'surname'], 'string', 'max' => 50],
            ['avatar', 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg, webp', 'maxSize' => 1024 * 1024 * 5],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'surname' => 'Фамилию',
            'avatar' => 'Выберите аватарку',
            'city' => 'Ваш город'
        ];
    }
}