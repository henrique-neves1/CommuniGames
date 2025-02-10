<?php

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\TeamLists $model */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var yii\db\ActiveRecord[] $alreadyAddedGames */

$this->title = 'Add Games to ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Team Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Add Games';

?>
    <h1>Add Games to <?= Html::encode($model->name) ?></h1>

    <div class="team-lists-add-games">

    <h1><?= Html::encode($this->title) ?></h1>

<?= Html::beginForm(['add-games', 'id' => $model->id], 'post') ?>

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
            'class' => 'yii\grid\CheckboxColumn',
            'checkboxOptions' => function ($model) use ($alreadyAddedGames) {
                return in_array($model->id, $alreadyAddedGames)
                    ? ['disabled' => true]
                    : ['value' => $model->id];
            },
        ],
    ],
]); ?>
<br>
<?= Html::submitButton('Done', ['class' => 'btn btn-primary']) ?>
<?= Html::endForm() ?>