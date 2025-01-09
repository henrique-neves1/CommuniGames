<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\GameSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="games-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'cover_name') ?>

    <?= $form->field($model, 'cover_data') ?>

    <?= $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'developer_name') ?>

    <?php // echo $form->field($model, 'publisher_name') ?>

    <?php // echo $form->field($model, 'releasedate') ?>

    <?php // echo $form->field($model, 'price') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
