<?php

namespace app\entity;

use yii\db\ActiveRecord;

/**
 * @property integer id
 * @property integer user_id
 * @property integer application_id
 * @property string text
 * @property string create_date
 */
class Comments extends ActiveRecord
{
    public function getUser() // Получение данных пользователя
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }
}