<?php
/**
 * @var $model
 * @var $cities
 */

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="page">
    <div class="form__wrapper">
        <div class="logo_block">
            <svg width="232" height="240" viewBox="0 0 232 240" fill="#fff" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M116.5 176C164.825 176 204 136.601 204 88C204 39.3989 164.825 0 116.5 0C68.1751 0 29 39.3989 29 88C29 136.601 68.1751 176 116.5 176ZM86 120C113.614 120 136 97.6142 136 70C136 42.3858 113.614 20 86 20C58.3858 20 36 42.3858 36 70C36 97.6142 58.3858 120 86 120Z"/>
                <path d="M32.208 229V211.816H8.64V229H6.336V194.68H8.64V209.752H32.208V194.68H34.512V229H32.208ZM46.5881 229V197.848H61.1321V199.768H48.7961V211.096H59.9321V212.968H48.7961V226.984H61.6121V229H46.5881ZM70.4475 229V197.848H72.6555V226.984H86.9595V229H70.4475ZM93.51 229V198.04C95.91 197.784 98.438 197.656 101.094 197.656C103.782 197.656 106.054 198.376 107.91 199.816C109.766 201.224 110.694 203.368 110.694 206.248C110.694 209.128 109.43 211.496 106.902 213.352C104.374 215.176 101.382 216.088 97.926 216.088C97.766 216.088 97.59 216.088 97.398 216.088V214.552C97.526 214.552 97.638 214.552 97.734 214.552C100.582 214.552 103.062 213.8 105.174 212.296C107.286 210.792 108.342 208.84 108.342 206.44C108.342 204.04 107.59 202.296 106.086 201.208C104.614 200.12 102.662 199.576 100.23 199.576C98.95 199.576 97.446 199.64 95.718 199.768V229H93.51ZM152.966 229.576C147.974 229.576 143.686 227.88 140.102 224.488C136.518 221.064 134.726 216.856 134.726 211.864C134.726 206.84 136.294 202.632 139.43 199.24C142.566 195.816 146.582 194.104 151.478 194.104C155.318 194.104 159.206 194.744 163.142 196.024L162.518 197.944C158.678 196.792 154.998 196.216 151.478 196.216C147.286 196.216 143.862 197.72 141.206 200.728C138.55 203.736 137.222 207.416 137.222 211.768C137.222 216.12 138.758 219.832 141.83 222.904C144.934 225.944 148.646 227.464 152.966 227.464C156.742 227.464 160.006 226.888 162.758 225.736L163.478 227.368C162.262 228.072 160.662 228.616 158.678 229C156.726 229.384 154.822 229.576 152.966 229.576ZM171.932 229V197.848H174.14V229H171.932ZM191.234 199.816H180.674V197.848H203.954V199.816H193.394V229H191.234V199.816ZM219.199 229H217.039V217.864L205.279 197.848H207.919L216.991 213.304C217.695 214.712 218.095 215.464 218.191 215.56C218.383 215.144 218.783 214.408 219.391 213.352L228.463 197.848H230.959L219.199 217.96V229Z"/>
            </svg>
        </div>
        <?php $form = ActiveForm::begin([
            'fieldConfig' => [
                'template' => "{label}<br>{input}<br>{error}",
                'labelOptions' => ['class' => 'label'],
                'inputOptions' => ['class' => 'input'],
                'errorOptions' => ['class' => 'error'],
            ],
        ]) ?>
        <?= $form->field($model, 'name')->textInput() ?>
        <?= $form->field($model, 'surname')->textInput() ?>
        <?= $form->field($model, 'city')->textInput(['list' => 'datalist']) ?>
        <datalist id="datalist">
            <?php foreach ($cities as $key => $value) : ?>
                <option><?= $value ?></option>
            <?php endforeach; ?>
        </datalist>
        <?= $form->field($model, 'email')->textInput() ?>
        <?= $form->field($model, 'password')->passwordInput(['class' => 'password']) ?>
        <?= $form->field($model, 'repeatPassword')->passwordInput(['class' => 'password']) ?>
        <label class="password_show">
            <?= FA::icon('eye') ?> Показать пароль
        </label>
        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn']) ?>
        <span>Уже есть аккаунт? <a href="/user/authorization">Авторизируйся!</a></span>
        <?php ActiveForm::end() ?>
    </div>
</div>
<script>
    document.querySelector('.password_show').addEventListener('click', () => {
        if (document.querySelector('.password').type !== 'text') {
            document.querySelector('.password').type = 'text';
            document.querySelector('.password_show i').classList.remove('fa-eye');
            document.querySelector('.password_show i').classList.add('fa-eye-slash');
        } else {
            document.querySelector('.password').type = 'password';
            document.querySelector('.password_show i').classList.remove('fa-eye-slash');
            document.querySelector('.password_show i').classList.add('fa-eye');
        }
    })
</script>
