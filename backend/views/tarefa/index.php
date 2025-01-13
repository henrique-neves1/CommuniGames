<?php

use common\models\Tarefas;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tarefas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tarefas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tarefas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'descricao',
            'feito',
            'user_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Tarefas $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id, 'user_id' => $model->user_id]);
                 }
            ],
        ],
    ]); ?>


</div>
