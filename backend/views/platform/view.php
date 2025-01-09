<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Platforms $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Platforms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<style>
    .image {
        max-width: 10%; /* Ensures the image is responsive */
        height: auto;
        margin-right: 0px; /* Adds space between the image and text */
    }
</style>
<div class="platforms-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="container">
        <img src="<?= Yii::$app->urlManager->createUrl(['platform/logo', 'id' => $model->id]) ?>" alt="Logo" class="image">
    </div>
    <br/>
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

</div>
