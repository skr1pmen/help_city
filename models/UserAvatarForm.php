<?php

namespace app\models;

use yii\base\Model;

class UserAvatarForm extends Model
{
    public $avatar;

    public function rules()
    {
        return [
            ['avatar', 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg, webp', 'maxSize' => 1024 * 1024 * 5],
        ];
    }

    public function attributeLabels()
    {
        return [
            'avatar' => 'Загрузите аватарку'
        ];
    }
}