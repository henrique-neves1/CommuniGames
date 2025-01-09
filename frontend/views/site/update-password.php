<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\User $model */

?>

<div class="update-password">

    <h1>Update Password</h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'currentPassword')->passwordInput(['maxlength' => true, 'placeholder' => 'Enter your current password']) ?>

    <?= $form->field($model, 'newPassword')->passwordInput(['maxlength' => true, 'placeholder' => 'Enter your new password']) ?>

    <?= $form->field($model, 'confirmNewPassword')->passwordInput(['maxlength' => true, 'placeholder' => 'Confirm your new password']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>