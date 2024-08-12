<?php

namespace app\models;

use app\repository\CityRepository;
use app\repository\UserRepository;
use yii\base\Model;

class RegistrationForm extends Model
{
    // Создание полей для формы
    public $email;
    public $password;
    public $repeatPassword;
    public $name;
    public $surname;
    public $city;

    public function rules() // Правила валидации полей
    {
        return [
            [['email', 'password', 'name', 'surname', 'city'], 'required'],
            ['email', 'email'],
            ['email', 'validateEmail'],
            ['city', 'validateCity'],
            ['password', 'string', 'length' => [8, 24]],
            ['repeatPassword', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    public function attributeLabels()  // Псевдонимы для полей
    {
        return [
            'email' => 'Ваша почта',
            'password' => 'Ваш пароль',
            'repeatPassword' => 'Подтвердите пароль',
            'name' => 'Ваше имя',
            'surname' => 'Ваша фамилия',
            'city' => 'Ваша город проживания',
        ];
    }

    public function validateEmail($attribute, $params) // Валидация почты
    {
        if (!$this->hasErrors()) { // Проверка на наличие ошибок
            $user = UserRepository::getUserByEmail($this->email); // Получение пользователя
            if ($user) { // Проверка на наличие данных
                $this->addError($attribute, 'Пользователь с такой почтой уже существует!'); // Создание ошибки
            }
        }
    }

    public function validateCity($attribute, $params) // Валидация города
    {
        if (!$this->hasErrors()) { // Проверка на наличие ошибок
            $city = CityRepository::getCity($this->city); // Получение города
            if (empty($city)) { // Проверка на наличие данных
                $this->addError($attribute, 'Некорректное или неправильное название города!'); // Создание ошибки
            }
        }
    }
}