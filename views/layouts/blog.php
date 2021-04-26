<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Url;
use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="is-preload">
    <?php $this->beginBody() ?>

    <!-- Content -->
    <div id="content">
        <div class="inner">
            <?= $content ?>
        </div>
    </div>

    <!-- Sidebar -->
    <div id="sidebar">

        <!-- Logo -->
        <h1 id="logo"><a href="<?= Url::home() ?>">BLOG</a></h1>

        <!-- Nav -->
        <nav id="nav">
            <ul>
                <?php if (Yii::$app->user->isGuest) : ?>
                    <li><a href="<?= Url::toRoute(['auth/login']) ?>">Войти</a></li>
                <?php else : ?>
                    <li><a href="<?= Url::toRoute(['auth/logout']) ?>">Выход (<?= Yii::$app->user->identity->name ?>)</a></li>
                <?php endif; ?>
            </ul>
        </nav>

        <!-- Search -->
        <section class="box search">
            <form method="get" action="<?= \yii\helpers\Url::to(['home/search']) ?>">
                <input type="text" class="text" name="q" placeholder="Search" />
            </form>
        </section>

        <?= $this->render('/partials/sidebar', []); ?>
    </div>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>