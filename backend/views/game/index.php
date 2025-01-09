<?php

use common\models\Games;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\GameSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Games';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="games-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Game', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'cover',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::img(
                        Url::to(['game/cover', 'id' => $model->id]),
                        ['alt' => 'Cover Image', 'style' => 'width:100px; height:auto;']
                    );
                },
            ],
            'name',
            //'description:ntext',
            //'developer_name',
            //'publisher_name',
            //'releasedate',
            [
                'attribute' => 'price',
                'value' => function ($model) {
                    return '€' . $model->price;
                },
                'format' => 'text',
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Games $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
