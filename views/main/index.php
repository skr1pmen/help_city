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

    <!--    <h2>Статистика за последние 7 дней</h2>-->
    <!--    --><?php //= ChartJs::widget([
    //        'type' => 'line',
    //        'options' => [
    //            'class' => 'line_grafic'
    //        ],
    //        'data' => [
    //            'labels' => [Date('D', strtotime("-6 days")), Date('D', strtotime("-5 days")), Date('D', strtotime("-4 days")), Date('D', strtotime("-3 days")), Date('D', strtotime("-2 days")), Date('D', strtotime("-1 days")), Date("D")],
    //            'datasets' => [
    //                [
    //                    'label' => "Заявка создана",
    //                    'borderColor' => "rgba(255, 0, 0, 1)",
    //                    'fill' => false,
    //                    'data' => [65, 59, 90, 81, 56, 55, 40]
    //                ],
    //                [
    //                    'label' => "Заявка обработана",
    //                    'borderColor' => "rgba(255, 220, 0, 1)",
    //                    'fill' => false,
    //                    'data' => [28, 48, 40, 19, 96, 27, 100]
    //                ],
    //                [
    //                    'label' => "Заявка в работе",
    //                    'borderColor' => "rgba(0, 24, 255, 1)",
    //                    'fill' => false,
    //                    'data' => [8, 4, 50, 29, 56, 35, 67]
    //                ],
    //                [
    //                    'label' => "Заявка решена",
    //                    'borderColor' => "rgba(0, 255, 0, 1)",
    //                    'fill' => false,
    //                    'data' => [12, 48, 20, 11, 106, 57, 87]
    //                ]
    //            ]
    //        ],
    //        'clientOptions' => [
    //            'legend' => [
    //                'display' => true,
    //                'position' => 'bottom',
    //                'labels' => [
    //                    'fontSize' => 12,
    //                    'fontColor' => "#425062",
    //                ]
    //            ],
    //            'tooltips' => [
    //                'enabled' => true,
    //                'intersect' => true
    //            ],
    //            'hover' => [
    //                'mode' => false
    //            ],
    //
    //        ],
    //    ]);
    //    ?>
</div>