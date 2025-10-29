<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
/** @var yii\web\View $this */
/** @var app\models\Post $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'content:ntext',
            [
            'attribute' => 'image_path',
            'label' => 'تصویر',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->image_path 
                    ? Html::img(Url::to('@web/' . $model->image_path), [
                        'alt' => 'تصویر پست',
                        'style' => 'max-width: 100px; height: auto;'
                    ]) 
                    : 'بدون تصویر';
            },
        ],
             [
                'attribute' => 'author',
                'value' => function ($model) {
                    return $model->author ? $model->author->username : '-';
                },
            ],
            [
                'attribute' => 'created at',
                'value' => function ($model) {
                    return \Morilog\Jalali\Jalalian::forge($model->created_at)->format('%B %d، %Y');
                },
            ],
            [
                'attribute' => 'updated at',
                'value' => function ($model) {
                    return \Morilog\Jalali\Jalalian::forge($model->updated_at)->format('%B %d، %Y');
                },
            ],
        ],
    ]) ?>

</div>
