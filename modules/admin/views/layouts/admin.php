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
                <li class="current"><a href="<?= \yii\helpers\Url::to(['/admin']) ?>">Главная | Админ</a></li>
                <li><a href="<?= \yii\helpers\Url::to(['/admin/article']) ?>">Статьи</a></li>
                <li><a href="<?= \yii\helpers\Url::to(['/admin/category']) ?>">Категории</a></li>
                <li><a href="<?= \yii\helpers\Url::to(['/admin/tag']) ?>">Тэги</a></li>
                <li><a href="<?= \yii\helpers\Url::to(['/admin/comment']) ?>">Коментарии</a></li>
            </ul>
        </nav>

        <?php $this->registerJsFile('/ckeditor/ckeditor.js'); ?>
        <?php $this->registerJsFile('/ckfinder/ckfinder.js'); ?>
        <script>
            $(document).ready(function() {
                var editor = CKEDITOR.replaceAll();
                CKFinder.setupCKEditor(editor);
            })
        </script>
    </div>

        <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>