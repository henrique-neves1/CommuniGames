<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Games $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Games', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<style>
    .container {
        display: flex;
        align-items: flex-start; /* Align items to the top */
        margin-left: -6px;
    }

    .image {
        max-width: 20%; /* Ensures the image is responsive */
        height: auto;
        margin-right: 20px; /* Adds space between the image and text */
    }

    .text-container {
        max-width: 600px; /* Adjust this value as needed */
    }
</style>
<div class="games-view">

    <div class="container">
        <?php
            if ($model->cover_path) {
                echo Html::img($model->cover_path, ['width' => '300']);
            }
        ?>
        <div class="text-container">
        <h3>Description:</h3> <?= Html::encode($model->description) ?>
        </div>
    </div>
    <h4><b>€<?= Html::encode($model->price) ?></b></h4>
    <p>
        <strong>Genre(s):</strong>
        <?= implode(', ', array_map(fn($genre) => Html::encode($genre->name), $model->genres)) ?>
    </p>
    <p>
        <strong>Platform(s):</strong>
        <?= implode(', ', array_map(fn($platform) => Html::encode($platform->name), $model->platforms)) ?>
    </p>
    <p><strong>Developer:</strong> <?= Html::encode($model->developer_name) ?></p>
    <p><strong>Publisher:</strong> <?= Html::encode($model->publisher_name) ?></p>
    <p><strong>Release Date:</strong> <?= Html::encode($model->releasedate) ?></p>
    <!--<h3>Genres</h3>
    <ul>
        <php foreach ($model->genres as $genre): >
            <li><= Html::encode($genre->name) ></li>
        <php endforeach; >
    </ul>-->

    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
        ],
    ]) ?>

</div>
