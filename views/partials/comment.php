<?php if (!empty($comments)) : ?>
    <?php foreach ($comments as $comment) : ?>
        
            <div class="bottom-comment">
                <!--bottom comment-->
                <div class="comment-img">
                    <img width="50" class="img-circle" src="<?= $comment->user->image; ?>" alt="">
                </div>
                <div class="comment-text">
                    <h5><?= $comment->user->name; ?></h5>
                    <p class="comment-date">
                        <?php
                        $time = new DateTime("$comment->date");
                        ?>
                        <?= $time->format('M.d.y H:i') ?>
                    </p>
                    <p class="para"><?= $comment->text; ?></p>
                </div>
            </div>
<hr>
    <?php endforeach; ?>
<?php endif; ?>
<!-- end bottom comment-->

<?php if (!Yii::$app->user->isGuest) : ?>
    <div class="leave-comment">
        <!--leave comment-->
        <h4>Ваш коментарий:</h4>
        <?php if (Yii::$app->session->getFlash('comment')) : ?>
            <div class="alert alert-success" role="alert">
                <?= Yii::$app->session->getFlash('comment'); ?>
            </div>
        <?php endif; ?>
        <?php $form = \yii\widgets\ActiveForm::begin([
            'action' => ['home/comment', 'id' => $article->id],
            'options' => ['class' => 'form-horizontal contact-form', 'role' => 'form']
        ]) ?>
        <div class="form-group">
            <div class="col-md-12">
                <?= $form->field($commentForm, 'comment')->textarea(['class' => 'form-control', 'placeholder' => 'Текст'])->label(false) ?>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Разместить коментарий</button>
        <?php \yii\widgets\ActiveForm::end(); ?>
    </div>
    <!--end leave comment-->
<?php endif; ?>