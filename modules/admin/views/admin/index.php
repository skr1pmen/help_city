<?php
/**
 * @var $stats
 * @var $applications
 * @var $statuses
 * @var $cityList
 */

?>

<div class="page">
    <div class="adminStats">
        <div class="box">
            <b><?= $stats['all'] ?></b>
            Всего заявок
        </div>
        <div class="box">
            <b><?= $stats['created'] ?></b>
            Заявок создано
        </div>
        <div class="box">
            <b><?= $stats['process'] ?></b>
            Заявок в обработке
        </div>
        <div class="box">
            <b><?= $stats['work'] ?></b>
            Заявок в работе
        </div>
        <div class="box">
            <b><?= $stats['finish'] ?></b>
            Заявок решено
        </div>
    </div>

    <table class="appTable">
        <thead>
            <tr>
                <th>Id</th>
                <th>Фото</th>
                <th>Заголовок</th>
                <th>Адрес</th>
                <th>Статус</th>
                <th>Видимость</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($applications as $app): ?>
                <tr onclick="window.location.href=`/application/app?id=<?= $app->id ?>`">
                    <td><?= $app->id ?></td>
                    <td><img src="/images/applications/<?= $app->id ?>/<?= $app->id ?>_1.jpg" alt="photo"></td>
                    <td><?= $app->title ?></td>
                    <td>г. <?= $cityList[$app->city_id] ?>, <?= $app->address ?></td>
                    <td><?= $statuses[$app->status_id] ?></td>
                    <td><?= $app->is_visible ? 'Видна' : 'Скрыта создателем' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
