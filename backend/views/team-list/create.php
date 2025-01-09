<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\TeamLists $model */

$this->title = 'Create Team Lists';
$this->params['breadcrumbs'][] = ['label' => 'Team Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-lists-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
