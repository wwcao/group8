<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Profiles */
/* @var $form ActiveForm */
?>
<div class="site-profile">

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'username')->textInput(['readonly' => true]) ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'lastname') ?>
        <?= $form->field($model, 'firstname') ?>
        <?= $form->field($model, 'phone_num') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-profile -->
