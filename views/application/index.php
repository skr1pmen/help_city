<?php
/**
 * @var $applications
 */

?>

<div class="page">
    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->is_verified) : ?>
        <a href="/application/create" class="btn btn-create"><i class="fa-solid fa-plus"></i>Создать заявку</a>
    <?php endif; ?>
    <div class="application__wrapper">
        <?php if (empty($applications)) : ?>
            <div class="not_application">
                Пока что тут пусто<br>¯\_(ツ)_/¯
            </div>
        <?php else : ?>
            <?php foreach ($applications as $application) : ?>
                <div class="app_card">
                    <img src="/images/applications/<?= $application->id ?>/<?= $application->id ?>_1.jpg" alt="">
                    <h3><?= $application->title ?></h3>
                    <span><?= $application->description ?></span>
                    <a href="/application/app?id=<?= $application->id ?>" class="btn">Подробнее</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>