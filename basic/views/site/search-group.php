<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
$this->title = 'Search Group';
?>

<div style="border-bottom: 1px solid black; margin-left: 10%; margin-right: 10%; margin-bottom: 5%;">
    <h1>
        Search
    </h1>
</div>

<div style="text-align: center; margin-top: 50px;">
    <?php $form = ActiveForm::begin(
            ['action'=> \yii\helpers\Url::to(['search-group']), 'method'=>'post']
            ); ?>
    <div>
        <?= Html::label("Keywords: ") ?>
        <?= Html::textInput("keywords", "", ['class'=>'searchtext', 'hint'=>"use ',' to seperate keywords"])?>
    </div>
    <div>
        <?= Html::label("Search by your interets") ?>
        <?= Html::checkbox("by_interest", $checked = false) ?>
    </div>
    <div>
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>    
    <?php ActiveForm::end(); ?>
</div>