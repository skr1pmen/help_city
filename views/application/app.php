<?php
/**
 * @var $app
 * @var $status
 * @var $statusesList
 */

use coderius\swiperslider\SwiperSlider;
use yii\bootstrap5\Modal;
use yii\widgets\Pjax;

$slides = [];
array_push($slides, "<img draggable='false' src='/images/applications/{$app->id}/{$app->id}_1.jpg'>");
if (file_exists("images/applications/{$app->id}/{$app->id}_2.jpg")) {
    array_push($slides, "<img draggable='false' src='/images/applications/{$app->id}/{$app->id}_2.jpg'>");
}
if (file_exists("images/applications/{$app->id}/{$app->id}_3.jpg")) {
    array_push($slides, "<img draggable='false' src='/images/applications/{$app->id}/{$app->id}_3.jpg'>");
}
if (file_exists("images/applications/{$app->id}/{$app->id}_4.jpg")) {
    array_push($slides, "<img draggable='false' src='/images/applications/{$app->id}/{$app->id}_4.jpg'>");
}
?>

<div class="page">
    <div class="app__wrapper">
        <?php if (count($slides) > 1) : ?>
            <?=
            SwiperSlider::widget([
                'slides' => $slides,
                'clientOptions' => [
                    'autoplay' => true,
                    'loop' => true,
                    'slidesPerView' => 1,
                    'pagination' => [
                        'clickable' => true,
                    ],
                    "scrollbar" => [
                        "el" => SwiperSlider::getItemCssClass(SwiperSlider::SCROLLBAR),
                        "hide" => false,
                    ],
                ],
                'showScrollbar' => false,
            ]);
            ?>
        <?php else : ?>
            <img draggable="false" draggable='false' class="cover"
                 src='/images/applications/<?= $app->id ?>/<?= $app->id ?>_1.jpg'>
        <?php endif; ?>
        <h1 class="title"><?= $app->title ?></h1>
        <span class="description"><?= $app->description ?></span>
        <div class="address">
            <span><b>Адрес: </b><?= $app->address ?></span>
            <img draggable="false" src="/images/applications/<?= $app->id ?>/map.png" alt="">
        </div>
        <span class="status status_<?= $app->status_id ?>">
            <?= $status ?>
            <?php if (Yii::$app->user->can('admin')): ?>
                <?php
                Modal::begin([
                    'title' => '<h2>Изменение статуса</h2>',
                    'toggleButton' => ['label' => "<i class='fa-regular fa-pen-to-square'></i>", 'class' => 'btn'],
                ]);
                ?>
                <?php Pjax::begin(); ?>
                <?php foreach ($statusesList as $key => $value): ?>
                    <a class="btn statLink"
                       href="/application/status?app_id=<?= $app->id ?>&status_id=<?= $key ?>"><?= $value ?></a>
                <?php endforeach; ?>
                <?php Pjax::end(); ?>
                <?php
                Modal::end();
                ?>
            <?php endif; ?>
        </span>
        <?php if ($app->user_id === Yii::$app->user->id || Yii::$app->user->can('admin')): ?>
            <div class="fun_btn">
                <a href="/application/edit?id=<?= $app->id ?>" class="btn">Редактировать</a>
                <a href="/application/delete?id=<?= $app->id ?>" class="btn">Удалить заявку</a>
            </div>
        <?php endif; ?>
    </div>
</div>
