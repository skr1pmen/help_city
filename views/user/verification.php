<?php
/**
 * @var $verification
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="page">
    <div class="verification__wrapper">
        <?php $form = ActiveForm::begin([
            'options' => [
                'class' => 'form-swiper',
                'enctype' => 'multipart/form-data'
            ],
            'fieldConfig' => [
                'template' => "{label}<br>{input}<br>{error}",
                'labelOptions' => ['class' => 'label'],
                'inputOptions' => ['class' => 'input'],
                'errorOptions' => ['class' => 'error'],
            ],
        ]) ?>

        <?= $form->field($verification, 'code')->textInput() ?>

        <?= Html::submitButton("Подтвердить", ['class' => 'btn']) ?>

        <?php ActiveForm::end() ?>
    </div>
</div>
