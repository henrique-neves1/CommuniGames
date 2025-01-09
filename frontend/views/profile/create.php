<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Profiles $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = "Let's start your profile";
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profiles-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="profiles-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'bio')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'picture_file')->fileInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
