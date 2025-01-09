<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Profiles $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="profiles-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model->user, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bio')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'picture_file')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
