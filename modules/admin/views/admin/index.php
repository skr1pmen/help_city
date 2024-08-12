<?php
/**
 * @var $stats
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
</div>
