<?php

use common\models\Platforms;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\PlatformSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Platforms';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="platforms-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Platforms', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'logo',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::img(
                        Url::to(['platform/logo', 'id' => $model->id]),
                        ['alt' => 'Logo', 'style' => 'width:50px; height:auto;']
                    );
                },
            ],
            'name',
            //'logo_name',
            //'logo_data',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Platforms $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
