<?php

namespace app\modules\admin\repository;

use app\entity\Applications;

class AdminRepository
{
    public static function getCountAllApp()
    {
        return Applications::find()->count();
    }

    public static function getCountCreatedApp()
    {
        return Applications::find()->where(['status_id' => 1])->count();
    }

    public static function getCountProcessApp()
    {
        return Applications::find()->where(['status_id' => 2])->count();
    }

    public static function getCountWorkApp()
    {
        return Applications::find()->where(['status_id' => 3])->count();
    }

    public static function getCountFinishedApp()
    {
        return Applications::find()->where(['status_id' => 4])->count();
    }
}