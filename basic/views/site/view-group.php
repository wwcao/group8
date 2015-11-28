<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<?php if(count($myGroups)>0) { ?>
<div>
    
    <h2 style="margin-left: 5%;">My Groups</h2>
    <ul class="groupsls">
    <?php foreach ($myGroups as $group): ?>
        <li><div class="mygroup">
                <div class="groupinfo">
                    <h4><?= Html::encode("{$group->groupname}") ?></h4>
                    <p>Created on <?= Html::encode("{$group->create_date}") ?></p>
                    <p style="text-align:left;"><?php 
                        $content = $group->descripton;
                        /*
                        if(strlen($content) > 150)
                        {
                            $content = substr($group->descripton, 1, 80) . '...';
                        }*/
                        ?>
                        <?= Html::encode("{$content}") ?>
                    </p>
                </div>
                <div class="actionOnGroup">
                    <?= Html::submitButton('Delete', ['class' => 'btn btn-primary']) ?>
                    <?= Html::submitButton('Close', ['class' => 'btn btn-primary']) ?>
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
                <div style="text-align:center;">
                    <h4><?= Html::encode("{$group->groupname}") ?></h4>
                    <p>Created on <?= Html::encode("{$group->create_date}") ?>
                    <br>By <?= Html::encode("{$group->l_user}") ?></p>
                </div>
                <div style="text-align: center;">
                    <?= Html::submitButton('Leave', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
    <div class="actionOnGroup">
        <?= LinkPager::widget(['pagination' => $paginationJoinedGroup]) ?>
    </div>
</div>

<?php }?>