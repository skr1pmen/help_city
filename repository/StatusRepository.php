<?php

namespace app\repository;

use app\entity\Statuses;

class StatusRepository
{
    public static function getStatus($id)
    {
        return Statuses::findOne(['id' => $id])->name;
    }
}