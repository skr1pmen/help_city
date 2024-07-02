<?php
/**
 * @var $applications
 */

?>

<div class="page">
    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->is_verified) : ?>
        <a href="/application/create" class="btn btn-create"><i class="fa-solid fa-plus"></i>Создать заявку</a>
    <?php endif; ?>
    <!--    --><?php //var_dump($applications); ?>
    <div class="application__wrapper">
        <?php foreach ($applications as $application) : ?>
            <div class="app_card">
                <!--                --><?php //=
                //                SwiperSlider::widget([
                //                    'slides' => [
                //                        '<img src="https://swiperjs.com/demos/images/nature-1.jpg">',
                //                        '<img src="https://swiperjs.com/demos/images/nature-2.jpg">'
                //                    ],
                //                    'clientOptions' => [
                //                        'autoplay' => true,
                //                        'loop' => true,
                //                        'slidesPerView' => 1,
                //                        'pagination' => [
                //                            'clickable' => true,
                //                        ],
                //                        "scrollbar" => [
                //                            "el" => SwiperSlider::getItemCssClass(SwiperSlider::SCROLLBAR),
                //                            "hide" => false,
                //                        ],
                //                    ],
                //                    'showScrollbar' => false,
                //                ]);
                //                ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>