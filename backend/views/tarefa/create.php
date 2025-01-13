<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Tarefas $model */

$this->title = 'Create Tarefas';
$this->params['breadcrumbs'][] = ['label' => 'Tarefas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tarefas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
