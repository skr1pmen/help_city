<?php

namespace app\entity;

use yii\db\ActiveRecord;

/**
 * @property integer id
 * @property string title
 * @property string description
 * @property string address
 * @property integer user_id
 * @property integer status_id
 * @property string create_date
 * @property string edit_date
 * @property integer city_id
 * @property boolean is_visible
 */
class Applications extends ActiveRecord
{
    public function getUser() // Получение данных пользователя
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    public function getStatus() // Получение данных статуса
    {
        return $this->hasOne(Statuses::class, ['id' => 'status_id']);
    }

    public function getComments() // Получение комментариев
    {
        return $this->hasMany(Comments::class, ['application_id' => 'id']);
    }
}