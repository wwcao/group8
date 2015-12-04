<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<?php if(count($myGroups['Groups'])>0) { ?>
<div>
    
    <h2 style="margin-left: 5%;">My Groups</h2>
    <ul class="groupsls">
    <?php foreach ($myGroups['Groups'] as $group): ?>
        <?php
            $groupname =$group->groupname;
            $l_user = $group->l_user;
            $grpName_clear = str_replace(' ', '`', $groupname);
        ?>
        <li>
            <div class="mygroup">
                <div class="groupinfo">
                    <h4><?= Html::encode("{$groupname}") ?></h4>
                    <p>Created on <?= Html::encode("{$group->create_date}") ?></p>
                    <p style="text-align:left;">
                        <?= Html::encode("{$group->description}") ?>
                    </p>
                </div>
                <div style="text-align: left; overflow:hidden;">
                    <?php $showMsg = ''; ?>
                    <?php foreach ($myGroups['Members'] as $member): ?>
                        <?php if($member->groupname == $groupname): ?>
                            <?php 
                                $m_users_str = $member->m_users;
                                $number = substr_count($m_users_str, ',')+1;
                                $showMsg = '(' . $number . ') You, ' . $m_users_str;
                            ?>
                            <p style="color: green; margin-left: 5px;"> <?=Html::encode("{$showMsg}") ?> </p>
                            <?php break;?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php if($showMsg==''): ?>
                            <p style="color: red; margin-left: 5px;"> <?php echo "(0) You"; ?> </p>
                    <?php endif; ?>
                </div>
                <div>
                    <form action="<?= Html::encode(\yii\helpers\Url::to(['user-action'])) ?>" method="post" style="margin: 0; padding: 0;">
                        <div>
                            <input type="hidden" name="_csrf" value=<?=Yii::$app->request->getCsrfToken()?>>
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="groupname" value=<?= Html::encode("{$grpName_clear}") ?>>
                            <input style="display: inline;" type="submit" value="Delete" class="btn btn-danger">
                        </div>
                    </form>
                            
                    <?php if($group->status == 'o') { ?>
                    <form action="<?= Html::encode(\yii\helpers\Url::to(['user-action'])) ?>" method="post" style="margin: 0; padding: 0;">
                        <div>
                            <input type="hidden" name="_csrf" value=<?=Yii::$app->request->getCsrfToken()?>>
                            <input type="hidden" name="action" value="close">
                            <input type="hidden" name="groupname" value=<?= Html::encode("{$grpName_clear}") ?>>
                            <input style="display: inline;" type="submit" value="Close" class="btn btn-primary">
                        </div>
                    </form>
                            
                        <?php } ?>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
    </ul>
    <div class="groups">
        <?= LinkPager::widget(['pagination' => $paginationMyGroup]) ?>
    </div>
</div>

<?php } else {?>
    <div class="no-group">
        <h2>No Group is created!</h2>
    </div>
    <?php }?>
<div style="height: 5%;"></div>

<?php if(count($joinedGroups)>0) { ?>
<div>
    
    <h3 style="margin-left: 5%;">Joined Groups</h3>
    <ul class="groups">
    <?php foreach ($joinedGroups as $group): ?>
        <li><div class="joinedgroup">
                <?php
                    $l_user_j = $group->l_user;
                    $groupname_j = $group->groupname;
                    $grpName_j_clear = str_replace(' ', '`', $groupname_j);
                ?>
                 <div class="groupinfo">
                    <h4><?= Html::encode("{$groupname_j}") ?></h4>
                    <p>Created on <?= Html::encode("{$group->create_date}") ?></p>
                    <p>By <?= Html::encode("{$l_user_j}") ?></p>
                    <p style="text-align:left;">
                        <?= Html::encode("{$group->description}") ?>
                    </p>
                </div>
                <div style="margin-top: 20px; margin-bottom: 5px;">
                    <?php if($group->status == 'o'){?>
                        <form action="<?= Html::encode(\yii\helpers\Url::to(['user-action'])) ?>" method="post">
                            <input type="hidden" name="_csrf" value=<?=Yii::$app->request->getCsrfToken()?>>
                            <input type="hidden" name="action" value="leave">
                            <input type="hidden" name="groupname" value=<?= Html::encode("{$grpName_j_clear}")?>>
                            <input type="hidden" name="l_user" value=<?= Html::encode("{$l_user_j}") ?>>
                            <input type="submit" value="Leave" class="btn btn-primary">
                        </form>
                    <?php } else {?>
                        <p style="color: green; font-size: 130%;">Ready!</p>
                    <?php } ?>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
    <div class="actionOnGroup">
        <?= LinkPager::widget(['pagination' => $paginationJoinedGroup]) ?>
    </div>
</div>

<?php }?>