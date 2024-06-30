<?php

namespace app\repository;

use app\entity\Applications;

class ApplicationRepository
{
    public static function getCountApplicationUser($user_id)
    {
        return count(Applications::findAll(['user_id' => $user_id]));
    }
}