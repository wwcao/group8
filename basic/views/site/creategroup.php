<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Groups */
/* @var $form ActiveForm */
?>
<div class="creategroup">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'groupname') ?>
        <?= $form->field($model, 'descripton')->textarea(['maxlength' => 300, 'rows' => 6, 'cols' => 50])?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- creategroup -->
