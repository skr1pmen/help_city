<?php

namespace app\models;

use yii\base\Model;

class CreateApplicationForm extends Model
{
    // Создание полей для формы
    public $title;
    public $description;
    public $address;
    public $photo_1;
    public $photo_2;
    public $photo_3;
    public $photo_4;

    public function rules() // Правила валидации полей
    {
        return [
            [['title', 'description', 'address'], 'required'],
            ['title', 'string', 'max' => 255],
            ['description', 'string', 'max' => 1000],
            ['photo_1', 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg, webp', 'maxSize' => 1024 * 1024 * 10],
            [['photo_2', 'photo_3', 'photo_4'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, webp', 'maxSize' => 1024 * 1024 * 10],
        ];
    }

    public function attributeLabels()  // Псевдонимы для полей
    {
        return [
            'title' => 'Заголовок',
            'description' => 'Описание',
            'address' => 'Адрес',
            'photo_1' => 'Главная фотка'
        ];
    }
}