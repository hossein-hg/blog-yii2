<?php
use yii\helpers\Html;
use yii\helpers\Url;
/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<div class="site-index">

  

    <div class="body-content">

        <div class="row">
            <?php foreach ($posts as $post): ?>
                <div class="col-lg-4 mb-3">
                    
                    <?php if ($post->image_path): ?>
                        <div>
                            <img src="<?= Url::to('@web/' . $post->image_path) ?>" alt="تصویر پست" style="max-width: 300px;">
                        </div>
                    
                    <?php endif; ?>
                    <h2><?= Html::encode($post->title) ?></h2>

                    <p>
                        <?= Html::encode($post->content) ?>
                    </p>

                    <p><a href="<?= Url::to(['site/view', 'id' => $post->id]) ?>" class="btn btn-primary">مشاهده پست</a></p>
                </div>
           
             <?php endforeach; ?>
        </div>

    </div>
</div>
