<!-- Post -->
<?php foreach ($articles as $article) : ?>
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <article class="box post post-excerpt">
                        <header>
                            <h2><a href="<?= yii\helpers\Url::toRoute(['home/single', 'id' => $article->id]); ?>"><?= $article->title; ?></a></h2> <!-- Название статьи -->
                            <h6><a href="<?= yii\helpers\Url::toRoute(['home/category', 'id' => $article->category->id]) ?>"><?= $article->category->title; ?></a></h6> <!-- Категория -->
                        </header>
                        <div class="info">
                            <span class="date">
                                <?php
                                $time = new DateTime("$article->date");
                                ?>
                                <span class="month"><?= $time->format('M') ?></span> <!-- Месяц -->
                                <span class="day"><?= $time->format('d') ?></span> <!-- День -->
                                <span class="year">, <?= $time->format('Y') ?></span> <!-- Год -->
                                <span class="time"> <?= $time->format('H:i') ?></span> <!-- Время -->
                            </span>
                            <ul class="stats">
                                <li><a href="#" class="icon fa-comment"><?= app\models\Comment::numberOfComments($article->id) ?></a></li>
                                <li><a href="#" class="icon fa-eye"><?= (int) $article->viewed ?></a></li>
                            </ul>
                        </div>
                        <div class="post-thumb">
                            <a href="<?= yii\helpers\Url::toRoute(['home/single', 'id' => $article->id]); ?>"><img src="<?= $article->getImage() ?>" alt="" /></a>
                        </div>
                        <p><?= $article->description; ?></p> <!-- Краткое описание -->
                    </article>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Pagination -->
<?= yii\widgets\LinkPager::widget(['pagination' => $pagination]); ?>