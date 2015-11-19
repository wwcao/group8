<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Groups */
/* @var $form ActiveForm */
?>
<div class="const">
<label>Creator:</label><br><?= Html::encode($model->l_user) ?> <br><br>
<label>Date:</label><br><?= Html::encode($model->create_date) ?> <br><br>
<label>Status:</label><br>

<?php
    $status = 'Open';
    if($model->status == 'c')
        $status = 'Closed';
    echo $status;
?>
</div>
<br><br>
<div class="creategroup">
    
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'groupname') ?>
        <?= $form->field($model, 'descripton')->textarea(['maxlength' => 300, 'rows' => 6, 'cols' => 50])?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- creategroup -->
