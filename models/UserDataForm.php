<?php

namespace app\models;

use yii\base\Model;

class UserDataForm extends Model
{
    // Создание полей для формы
    public $avatar;
    public $name;
    public $surname;
    public $city;

    public function rules() // Правила валидации полей
    {
        return [
            [['name', 'surname', 'city'], 'required'],
            [['name', 'surname'], 'string', 'max' => 50],
            ['avatar', 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, webp', 'maxSize' => 1024 * 1024 * 5],
        ];
    }

    public function attributeLabels()  // Псевдонимы для полей
    {
        return [
            'name' => 'Имя',
            'surname' => 'Фамилию',
            'avatar' => 'Выберите аватарку',
            'city' => 'Ваш город'
        ];
    }
}