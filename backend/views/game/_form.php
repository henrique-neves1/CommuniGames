<?php

use common\models\Genres;
use common\models\Platforms;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Games $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="games-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'coverFile')->fileInput() ?>

    <?= $form->field($model, 'developer_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'publisher_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'releasedate')->input('date') ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <h3>Genres</h3>
    <?= $form->field($model, 'genreIds')->checkboxList(
        ArrayHelper::map(Genres::find()->all(), 'id', 'name'),
        ['separator' => '<br>']
    )->label(false) ?>

    <h3>Platforms</h3>
    <?= $form->field($model, 'platformIds')->checkboxList(
        ArrayHelper::map(Platforms::find()->all(), 'id', 'name'),
        ['separator' => '<br>']
    )->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
