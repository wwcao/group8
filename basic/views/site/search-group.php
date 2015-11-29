<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
$this->title = 'Search Result';
if($keywords == "")
{
    $this->title = 'Search Group';
}
?>

<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($keywords, 'keywords')->input('text', ['style'=>'width: 60%'])->hint("use seperator ','") ?>
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>

<?php if($Groups!=Null&&count($Groups)>0) { ?>
<div>
    <h4 style="margin-left: 5%;">Match Group</h4>
    <p style="margin-left: 6%;">Keywords: <?= Html::encode($keywords->keywords); ?></p>
    <ul class="groupsls">
    <?php foreach ($Groups as $group): ?>
        <li><div class="mygroup">
                <div class="groupinfo">
                    <h4><?= Html::encode("{$group->groupname}") ?>
                    By <?= Html::encode("{$group->l_user}") ?></h4>
                    <p>Created on <?= Html::encode("{$group->create_date}") ?></p>
                    <p style="text-align:left;">
                        <?php 
                            $content = $group->description;
                        ?>
                        <?= Html::encode("{$content}") ?>
                        <?= Html::a('Join', ['join', 'f_user' => $group->l_user, 'groupname'=>$group->groupname], ['class' => 'btn btn-primary']) ?>
                    </p>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
    </ul>
    <div class="groups">
        <?= LinkPager::widget(['pagination' => $Pagination]) ?>
    </div>
</div>

<?php } else {?>
    <?php if($keywords->keywords!="") {?>
        <div class="no-group">
            <h2>No Group is found!</h2>
        </div>
    <?php }?>
<?php }?>
