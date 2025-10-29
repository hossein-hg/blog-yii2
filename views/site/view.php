<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = Html::encode($post->title);
?>
 <?php if ($post->image_path): ?>
                        <div>
                            <img src="<?= Url::to('@web/' . $post->image_path) ?>" alt="تصویر پست" style="max-width: 300px;">
                        </div>
                    
<?php endif; ?>
<h1><?= Html::encode($post->title) ?></h1>
<div class="post-content">
    <p><?= Html::encode($post->content) ?></p>
    
</div>

<h2>نظرات</h2>
<?php if ($post->comments): ?>
    <div class="comments">
        <?php foreach ($post->comments as $comment): ?>
            <div class="comment">
                <p><strong><?= Html::encode($comment->user->username) ?>:</strong> <?= Html::encode($comment->content) ?></p>
               
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>هیچ نظری ثبت نشده است.</p>
<?php endif; ?>

<?php if (!Yii::$app->user->isGuest): ?>
    <h3>ثبت نظر</h3>
    <?php $form = ActiveForm::begin(['action' => ['site/add-comment', 'post_id' => $post->id]]); ?>
        <?= $form->field($comment, 'content')->textarea(['rows' => 4, 'value'=>'']) ?>
        <div class="form-group">
            <?= Html::submitButton('ارسال نظر', ['class' => 'btn btn-success']) ?>
        </div>
    <?php ActiveForm::end(); ?>
<?php else: ?>
    <p>برای ثبت نظر، لطفاً <a href="<?= Url::to(['site/login']) ?>">وارد شوید</a>.</p>
<?php endif; ?>