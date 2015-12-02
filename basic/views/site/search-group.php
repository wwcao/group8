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

<?php $form = ActiveForm::begin(
        ['action'=> \yii\helpers\Url::to(['search-group']),]
        ); ?>
	<!--	Adding fields: add variable in models/SignupForm.php -->
    <?= Html::textInput("keywords", "", ['class'=>'searchtext'])?>
    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>

<?php if($Groups!=Null&&count($Groups)>0) { ?>
<div>
    <h4 style="margin-left: 5%;">Match Group</h4>
    <p style="margin-left: 6%;">Keywords: <?= Html::encode($keywords); ?></p>
    <ul class="groupsls">
    <?php foreach ($Groups as $group): ?>
        <?php
            $l_user = $group->l_user;
            $groupname = $group->groupname;
            $grpName_clear = str_replace(' ', '`', $groupname);
        ?>
        <li><div class="mygroup">
                <div class="groupinfo">
                    <h4><?= Html::encode("{$groupname}") ?>
                    By <?= Html::encode("{$l_user}") ?></h4>
                    <p>Created on <?= Html::encode("{$group->create_date}") ?></p>
                    <p style="text-align:left;">
                        <?php 
                            $content = $group->description;
                        ?>
                        <?= Html::encode("{$content}") ?>
                        <form action="<?= Html::encode(\yii\helpers\Url::to(['user-action'])) ?>" method="post">
                            <input type="hidden" name="_csrf" value=<?=Yii::$app->request->getCsrfToken()?>>
                            <input type="hidden" name="action" value="leave">
                            <input type="hidden" name="groupname" value=<?= Html::encode("{$grpName_clear}") ?>>
                            <input type="hidden" name="l_user" value=<?= Html::encode("{$l_user}") ?>>
                            <input type="submit" value="Leave" class="btn btn-primary">
                        </form>
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

<?php }?>