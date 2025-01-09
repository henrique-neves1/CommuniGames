<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\TeamLists $model */

$this->title = 'Update Team Lists: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Team Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="team-lists-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
