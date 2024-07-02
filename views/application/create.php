<?php
/**
 * @var $model
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="page">
    <div class="create__wrapper">
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

        <label class="photo">
            <img class="photo_1" src="/images/only_logo.svg" alt="">
            <?= $form->field($model, 'photo_1')->fileInput(['class' => 'file_input_1', 'style' => 'display:none']) ?>
        </label>
        <div class="additional_photos">
            <label class="additional_photo">
                <img class="photo_2" src="/images/only_logo.svg" alt="">
                <?= $form->field($model, 'photo_2')->fileInput(['class' => 'file_input_2', 'style' => 'display:none'])->label('') ?>
            </label>
            <label class="additional_photo">
                <img class="photo_3" src="/images/only_logo.svg" alt="">
                <?= $form->field($model, 'photo_3')->fileInput(['class' => 'file_input_3', 'style' => 'display:none'])->label('') ?>
            </label>
            <label class="additional_photo">
                <img class="photo_4" src="/images/only_logo.svg" alt="">
                <?= $form->field($model, 'photo_4')->fileInput(['class' => 'file_input_4', 'style' => 'display:none'])->label('') ?>
            </label>
            <span>Дополнительные фотографии</span>
        </div>
        <?= $form->field($model, 'title')->textInput() ?>
        <?= $form->field($model, 'description')->textarea() ?>
        <?= $form->field($model, 'address')->textInput() ?>
        <?= Html::submitButton("Создать", ['class' => 'btn']) ?>

        <?php ActiveForm::end() ?>
    </div>
</div>
<script>
    document.querySelector('.file_input_1').onchange = function (event) {
        var reader = new FileReader();
        reader.onload = function () {
            var output = document.querySelector('.photo_1');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    };
    document.querySelector('.file_input_2').onchange = function (event) {
        var reader = new FileReader();
        reader.onload = function () {
            var output = document.querySelector('.photo_2');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    };
    document.querySelector('.file_input_3').onchange = function (event) {
        var reader = new FileReader();
        reader.onload = function () {
            var output = document.querySelector('.photo_3');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    };
    document.querySelector('.file_input_4').onchange = function (event) {
        var reader = new FileReader();
        reader.onload = function () {
            var output = document.querySelector('.photo_4');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    };
</script>