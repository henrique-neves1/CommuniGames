<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Genres $model */

$this->title = 'Create Genres';
$this->params['breadcrumbs'][] = ['label' => 'Genres', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="genres-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
