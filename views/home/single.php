<!--main content start-->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <article class="post">
                    <div class="post-thumb">
                        <a href="blog.html"><img src="<?= $article->getImage(); ?>" alt=""></a>
                    </div>
                    <div class="post-content">
                        <header class="entry-header text-center text-uppercase">
                            <h6><a href="#"><?= $article->category->title ?></a></h6>
                            <h1 class="entry-title"><a href="blog.html"><?= $article->title ?></a></h1>
                        </header>
                        <div class="text-justify">
                            <?= $article->content ?>
                        </div>
                        <div class="decoration">
                            <?php foreach ($tags as $tag) : ?>
                                <a href="<?= yii\helpers\Url::toRoute(['home/category', 'id' => $tag->id]) ?>" class="btn btn-default"><?= $tag->title ?></a>
                            <?php endforeach; ?>
                        </div>

                        <div class="social-share">
                            <?php
                            $time = new DateTime("$article->date");
                            ?>
                            <p class="h4">Автор: <?= $article->author->name?> | <?= $time->format('M.d.y H:i') ?></p>
                        </div>
                    </div>
                    <hr>
                </article>
                
                <?= $this->render('/partials/comment', [
                    'article' => $article,
                    'comments' => $comments,
                    'commentForm' => $commentForm,
                ]) ?>
                
            </div>
        </div>
    </div>
</div>