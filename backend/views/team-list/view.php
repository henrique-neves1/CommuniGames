<?php

use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var common\models\TeamLists $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Team Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="team-lists-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <h2>Games in this Team List</h2>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'cover',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->cover_path
                        ? Html::img($model->cover_path, ['width' => '100'])
                        : null;
                },
            ],
            'name',
            [
                'attribute' => 'price',
                'value' => function ($model) {
                    return '€' . $model->price;
                },
                'format' => 'text',
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{remove}',
                'buttons' => [
                    'remove' => function ($url, $model) {
                        return Html::a(
                            '<i class="fas fa-minus-circle"></i>',
                            ['team-list/remove-game', 'teamListId' => Yii::$app->request->get('id'), 'gameId' => $model->id],
                            [
                                'title' => 'Remove',
                                'data' => [
                                    'confirm' => 'Are you sure you want to remove this game?',
                                    'method' => 'post',
                                ],
                                'class' => 'btn btn-danger btn-sm',
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>

    <p>
        <?= Html::a('Add Games', ['add-games', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>

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
            'name',
        ],
    ]) ?>

</div>
