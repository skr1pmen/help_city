<?php

namespace app\repository;

use app\entity\Applications;

class MainRepository
{
    public static function createdApplication()
    {
        $createdApplication = [];
        $dates = [];
        for ($i = 0; $i < 7; $i++) {
            $dates[] = Date('Y-m-d', strtotime("-{$i} days"));
        }
        foreach ($dates as $date) {
            $createdApplication[] = count(Applications::findAll(['create_date' => $date, 'status_id' => 1]));
        };
        return $createdApplication;
    }

    public static function processingApplication()
    {
        $processingApplication = [];
        $dates = [];
        for ($i = 0; $i < 7; $i++) {
            $dates[] = Date('Y-m-d', strtotime("-{$i} days"));
        }
        foreach ($dates as $date) {
            $processingApplication[] = count(Applications::findAll(['create_date' => $date, 'status_id' => 2]));
        };
        return $processingApplication;
    }

    public static function atWorkApplication()
    {
        $atWorkApplication = [];
        $dates = [];
        for ($i = 0; $i < 7; $i++) {
            $dates[] = Date('Y-m-d', strtotime("-{$i} days"));
        }
        foreach ($dates as $date) {
            $atWorkApplication[] = count(Applications::findAll(['create_date' => $date, 'status_id' => 3]));
        };
        return $atWorkApplication;
    }

    public static function resolvedApplication()
    {
        $resolvedApplication = [];
        $dates = [];
        for ($i = 0; $i < 7; $i++) {
            $dates[] = Date('Y-m-d', strtotime("-{$i} days"));
        }
        foreach ($dates as $date) {
            $resolvedApplication[] = count(Applications::findAll(['create_date' => $date, 'status_id' => 4]));
        };
        return $resolvedApplication;
    }
}