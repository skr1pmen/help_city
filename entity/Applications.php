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
 */
class Applications extends ActiveRecord
{
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    public function getStatus()
    {
        return $this->hasOne(Statuses::class, ['id' => 'status_id']);
    }

    public function getComments()
    {
        return $this->hasMany(Comments::class, ['application_id' => 'id']);
    }
}