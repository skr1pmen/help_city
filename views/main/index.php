<?php
/**
 * @var $created
 * @var $processing
 * @var $atWork
 * @var $resolved
 */

use dosamigos\chartjs\ChartJs;

?>

<div class="page">
    <div class="welcomeBlock">
        <div>
            <img src="/images/only_logo.svg" alt="">
            <h1>HelpCity</h1>
            <span>Сделай свой город лучше сам!</span>
        </div>
        <img src="/images/7965ebb1-5036-4ada-bb03-8ca0c48e5a69-transformed.png" alt="">
        <i class="fa-solid fa-angles-down"></i>
    </div>

    <h2>Статистика за последние 7 дней</h2>
    <?= ChartJs::widget([
        'type' => 'line',
        'options' => [
            'class' => 'line_grafic'
        ],
        'data' => [
            'labels' => [Date('D', strtotime("-6 days")), Date('D', strtotime("-5 days")), Date('D', strtotime("-4 days")), Date('D', strtotime("-3 days")), Date('D', strtotime("-2 days")), Date('D', strtotime("-1 days")), Date("D")],
            'datasets' => [
                [
                    'label' => "Заявка создана",
                    'borderColor' => "#ff6200",
                    'fill' => false,
                    'data' => $created
                ],
                [
                    'label' => "Заявка обработана",
                    'borderColor' => "#002aff",
                    'fill' => false,
                    'data' => $processing
                ],
                [
                    'label' => "Заявка в работе",
                    'borderColor' => "#37ff00",
                    'fill' => false,
                    'data' => $atWork
                ],
                [
                    'label' => "Заявка решена",
                    'borderColor' => "#167a00",
                    'fill' => false,
                    'data' => $resolved
                ]
            ]
        ],
        'clientOptions' => [
            'legend' => [
                'display' => true,
                'position' => 'bottom',
                'labels' => [
                    'fontSize' => 18,
                    'fontColor' => "#425062",
                ]
            ],
            'tooltips' => [
                'enabled' => true,
                'intersect' => true
            ],
            'hover' => [
                'mode' => false
            ],

        ],
    ]);
    ?>
</div>