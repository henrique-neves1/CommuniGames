<?php

use common\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Tarefas $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tarefas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

    <h3>Para que utilizador?</h3>
    <?= $form->field($model, 'user_id')->radioList(
        ArrayHelper::map(User::find()->all(), 'id', 'username'),
        ['separator'=> '<br>']
    )->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
