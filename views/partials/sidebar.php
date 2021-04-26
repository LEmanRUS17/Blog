<?php

use app\models\Article;
use app\models\Category;

$popular    = Article::getPopular(); // Получение популярных статей
$recent     = Article::getRecent();  // Получение последних статей
$categories = Category::getAll();    // Получение всех категорий
?>

<!-- Популярные посты -->
<section class="box recent-posts">
    <aside class="widget border pos-padding">
        <h2 class="widget-title text-uppercase text-center">Популярные посты</h2>
        
        <ul>
        <?php foreach ($popular as $article) : ?>
            <li class="popular-post">
                <a href="<?= Yii\helpers\Url::toRoute(['home/single', 'id' => $article->id]); ?>" class="popular-img"><img src="<?= $article->getImage(); ?>" alt="" class="popular">
                    <div class="p-overlay"></div>
                </a>
                <a href="<?= Yii\helpers\Url::toRoute(['home/single', 'id' => $article->id]); ?>" class="text-uppercase"><?= $article->title ?></a>
                <span class="p-date">
                    <?php
                    $time = new DateTime("$article->date");
                    echo $time->format('M.d.Y');
                    ?>
                </span>
            </li>
        <?php endforeach; ?>
        </ul>
    </aside>
</section>

<!-- Последние посты -->
<section class="box recent-posts">
    <aside class="widget border pos-padding">
        <h2 class="widget-title text-uppercase text-center">Последние посты</h2>
        <ul>
            <?php foreach ($recent as $article) : ?>
                <li class="thumb-latest-posts">
                    <a href="<?= Yii\helpers\Url::toRoute(['home/single', 'id' => $article->id]); ?>" class="recent-img"><img src="<?= $article->getImage() ?>" alt="">
                        <div class="p-overlay"></div>
                    </a>
                    <a href="<?= Yii\helpers\Url::toRoute(['home/single', 'id' => $article->id]); ?>" class="text-uppercase"><?= $article->title ?></a>
                    <span class="p-date">
                        <?php
                        $time = new DateTime("$article->date");
                        echo $time->format('M.d.Y');
                        ?>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    </aside>
</section>

<section class="box recent-comments">
    <div class="primary-sidebar">
        <aside class="widget border pos-padding">
            <h3 class="widget-title text-uppercase text-center">Категории</h3>
            <ul>
                <?php foreach ($categories as $category) : ?>
                    <li>
                        <a href="<?= Yii\helpers\Url::toRoute(['home/category', 'id' => $category->id]); ?>"><?= $category->title ?></a>
                        <span class="post-count pull-right"> (<?= $category->getArticlesCount(); ?>)</span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </aside>
    </div>
</section>