<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Checkout';
?>

    <h1>Checkout</h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'email')->input('email') ?>
<?= $form->field($model, 'taxnumber')->textInput(['maxlength' => 9]) ?>
<?= $form->field($model, 'residence')->textInput(['maxlength' => 100]) ?>
<?= $form->field($model, 'zipcode')->textInput(['maxlength' => 8]) ?>

    <div class="form-group">
        <?= Html::submitButton('Generate Invoice', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>