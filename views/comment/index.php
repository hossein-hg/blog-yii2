<?php

use app\models\Comment;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\CommentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Comments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
             [
                'attribute' => 'post',
                'value' => function ($model) {
                    return $model->post ? $model->post->title : '-';
                },
            ],
            [
                'attribute' => 'author',
                'value' => function ($model) {
                    return $model->user ? $model->user->username : '-';
                },
            ],
            'content:ntext',
            [
                'attribute' => 'created at',
                'value' => function ($model) {
                    return \Morilog\Jalali\Jalalian::forge($model->created_at)->format('%B %d، %Y');
                },
            ],
           
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Comment $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                 'template' => '{view} {delete}',
            ],
        ],
    ]); ?>


</div>
