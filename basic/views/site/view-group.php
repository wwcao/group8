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
            $groupname = $group->groupname; 
            $l_user = $group->l_user;
        ?>
        <li><div class="mygroup">
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
                <div class="actionOnGroup">
                    <?= Html::a('Delete', 
                            ['user-action', 'action'=>'delete', 'groupinfo' => $l_user .'`'. $groupname.'`'.  time()], 
                            ['class' => 'btn btn-danger',
                             'data' => [
                             'confirm' => 'Are you sure you want to delete this Group?',
                             'method' => 'post',
                            ]])
                        ?>
                    <?php if($group->status == 'o'){?>
                        <?= Html::a('Close', ['user-action', 'action'=>'close', 'groupinfo' => $l_user .'`'. $groupname], ['class' => 'btn btn-primary']) ?>
                    <?php }?>
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
                    $l_user = $group->l_user;
                    $groupname = $group->groupname;
                ?>
                <div style="text-align:center;">
                    <h4><?= Html::encode("{$groupname}") ?></h4>
                    <p>Created on <?= Html::encode("{$group->create_date}") ?>
                    <br>By <?= Html::encode("{$l_user}") ?></p>
                </div>
                <div style="text-align: center;">
                    <?php if($group->status == 'o'){?>
                        <?= Html::a('Leave', 
                            ['user-action', 'action'=>'leave', 'groupinfo' => $l_user .'`'. $groupname.','.  time()], 
                            ['class' => 'btn btn-danger',
                             'data' => [
                             'confirm' => 'Are you sure you want to leave this Group?',
                             'method' => 'post',
                            ]])
                        ?>
                    <?php } else {?>
                        <?= Html::a('Stayed', ['class' => 'btn btn-gray']) ?>
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