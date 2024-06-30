<?php
/**
 * @var $countApplication
 * @var $edit
 * @var $verification
 */

use rmrevin\yii\fontawesome\FA;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

?>
<div class="page">
    <div class="profile__wrapper">
        <div class="profile">
            <?php if (file_exists('images/user_avatar/' . Yii::$app->user->id . '.jpg')) : ?>
                <img src="/images/user_avatar/<?= Yii::$app->user->id ?>.jpg" alt="">
            <?php else : ?>
                <div class="avatar">
                    <?= mb_substr(Yii::$app->user->identity->name, 0, 1) ?>
                    <?= mb_substr(Yii::$app->user->identity->surname, 0, 1) ?>
                </div>
            <?php endif; ?>

            <h1>
                <?= Yii::$app->user->identity->surname ?>
                <?= Yii::$app->user->identity->name ?>
            </h1>
            <?php
            Modal::begin([
                'title' => '<h2>Изменение данных</h2>',
                'toggleButton' => ['label' => FA::icon('edit') . ' Редактировать', 'class' => 'btn'],
            ]);
            ?>
            <?php Pjax::begin(); ?>
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

            <label class="edit_avatar">
                <?php if (file_exists('images/user_avatar/' . Yii::$app->user->id . '.jpg')) : ?>
                    <img src="/images/user_avatar/<?= Yii::$app->user->id ?>.jpg" alt="">
                <?php else: ?>
                    <img class="ava"
                         src="https://i2.wp.com/vdostavka.ru/wp-content/uploads/2019/05/no-avatar.png?fit=512%2C512&ssl=1"
                         alt="">
                <?php endif; ?>
                <?= $form->field($edit, 'avatar')->fileInput(['class' => 'file_input', 'style' => 'display:none']) ?>
            </label>
            <?= $form->field($edit, 'name')->textInput(['value' => Yii::$app->user->identity->name]) ?>
            <?= $form->field($edit, 'surname')->textInput(['value' => Yii::$app->user->identity->surname]) ?>

            <?= Html::submitButton("Сохранить", ['class' => 'btn']) ?>

            <?php ActiveForm::end() ?>
            <?php Pjax::end(); ?>
            <?php
            Modal::end();
            ?>
            <?php if ($countApplication >= 0) : ?>
                <span class="app">Заявок: <a
                            href="/application/index?form_user=<?= Yii::$app->user->id ?>"><?= $countApplication ?></a></span>
            <?php else : ?>
                <?php
                Modal::begin([
                    'title' => '<h2>Подтверждение аккаунта</h2>',
                    'toggleButton' => ['label' => FA::icon('check') . ' Подтвердить аккаунт', 'class' => 'btn'],
                ]);
                ?>
                <?php Pjax::begin(); ?>
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

                <?= $form->field($verification, 'code')->textInput(['maxlength' => 6]) ?>

                <?= Html::submitButton("Подтвердить", ['class' => 'btn']) ?>

                <?php ActiveForm::end() ?>
                <?php Pjax::end(); ?>
                <?php
                Modal::end();
                ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
    document.querySelector('.file_input').onchange = function (event) {
        var reader = new FileReader();
        reader.onload = function () {
            var output = document.querySelector('.ava');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    };
</script>