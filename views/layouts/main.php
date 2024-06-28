<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use rmrevin\yii\fontawesome\FA;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <title><?= $this->title ?></title>
    <?php $this->head() ?>
</head>
    <body>
<?php $this->beginBody() ?>

        <main class="deactivate">
            <nav>
                <a href="/">
                    <svg class="logo" width="307" height="75" viewBox="0 0 307 75" fill="#fff"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M32 64.3657C49.6731 64.3657 64 49.957 64 32.1829C64 14.4088 49.6731 0 32 0C14.3269 0 0 14.4088 0 32.1829C0 49.957 14.3269 64.3657 32 64.3657ZM20.8457 43.8857C30.9447 43.8857 39.1314 35.6989 39.1314 25.6C39.1314 15.5011 30.9447 7.31428 20.8457 7.31428C10.7468 7.31428 2.56002 15.5011 2.56002 25.6C2.56002 35.6989 10.7468 43.8857 20.8457 43.8857Z"/>
                        <path d="M107.208 64V46.816H83.64V64H81.336V29.68H83.64V44.752H107.208V29.68H109.512V64H107.208ZM121.588 64V32.848H136.132V34.768H123.796V46.096H134.932V47.968H123.796V61.984H136.612V64H121.588ZM145.448 64V32.848H147.656V61.984H161.96V64H145.448ZM168.51 64V33.04C170.91 32.784 173.438 32.656 176.094 32.656C178.782 32.656 181.054 33.376 182.91 34.816C184.766 36.224 185.694 38.368 185.694 41.248C185.694 44.128 184.43 46.496 181.902 48.352C179.374 50.176 176.382 51.088 172.926 51.088C172.766 51.088 172.59 51.088 172.398 51.088V49.552C172.526 49.552 172.638 49.552 172.734 49.552C175.582 49.552 178.062 48.8 180.174 47.296C182.286 45.792 183.342 43.84 183.342 41.44C183.342 39.04 182.59 37.296 181.086 36.208C179.614 35.12 177.662 34.576 175.23 34.576C173.95 34.576 172.446 34.64 170.718 34.768V64H168.51ZM227.966 64.576C222.974 64.576 218.686 62.88 215.102 59.488C211.518 56.064 209.726 51.856 209.726 46.864C209.726 41.84 211.294 37.632 214.43 34.24C217.566 30.816 221.582 29.104 226.478 29.104C230.318 29.104 234.206 29.744 238.142 31.024L237.518 32.944C233.678 31.792 229.998 31.216 226.478 31.216C222.286 31.216 218.862 32.72 216.206 35.728C213.55 38.736 212.222 42.416 212.222 46.768C212.222 51.12 213.758 54.832 216.83 57.904C219.934 60.944 223.646 62.464 227.966 62.464C231.742 62.464 235.006 61.888 237.758 60.736L238.478 62.368C237.262 63.072 235.662 63.616 233.678 64C231.726 64.384 229.822 64.576 227.966 64.576ZM246.932 64V32.848H249.14V64H246.932ZM266.234 34.816H255.674V32.848H278.954V34.816H268.394V64H266.234V34.816ZM294.199 64H292.039V52.864L280.279 32.848H282.919L291.991 48.304C292.695 49.712 293.095 50.464 293.191 50.56C293.383 50.144 293.783 49.408 294.391 48.352L303.463 32.848H305.959L294.199 52.96V64Z"/>
                    </svg>
                </a>
                <hr>
                <ul>
                    <li><a href=""><?= FA::icon('home') ?>Главная страница</a></li>
                    <li><a href=""><?= FA::icon('ticket') ?>Все заявки</a></li>
                    <li><a href=""><?= FA::icon('info') ?>О проекте</a></li>
                    <li><a href=""><?= FA::icon('user') ?>Профиль</a></li>
                </ul>
                <hr>
                <ul>
                    <li>
                        <label>
                            <?= FA::icon('square', ['class' => 'btn__theme']) ?>
                            Сменить тему
                            <input type="checkbox" hidden="" id="theme">
                        </label>
                    </li>
                </ul>
                <hr>
                <span class="version">Version: <?= Yii::$app->params['version'] ?></span>
            </nav>
            <header>
                <h1><?= $this->title ?></h1>
                <?php if (Yii::$app->user->isGuest) : ?>
                    <a href="/user/authorization" class="btn">Войти</a>
                <?php else : ?>
                    <a class="user_block" href="/user/profile?id=<?= Yii::$app->user->id ?>">
                        <?php if (file_exists('/images/user_avatar/' . Yii::$app->user->id . 'jpg')) : ?>
                            <img src="/images/user_avatar/'<?= Yii::$app->user->id ?>'jpg'" alt="">
                        <?php else: ?>
                            <div class="avatar">
                                <?= mb_substr(Yii::$app->user->identity->name, 0, 1) ?>
                                <?= mb_substr(Yii::$app->user->identity->surname, 0, 1) ?>
                            </div>
                        <?php endif; ?>
                        <?= Yii::$app->user->identity->surname ?>
                        <?= Yii::$app->user->identity->name ?>
                    </a>
                <?php endif; ?>
            </header>
            <div class="content">
        <?= $content ?>
    </div>
</main>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
