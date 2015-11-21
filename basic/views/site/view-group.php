<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<?php if(count($myGroups)>0) { ?>
<div>
    
    <h2>My Groups</h2>
    <ul class="groups">
    <?php foreach ($myGroups as $group): ?>
        <li><div class="group">
                <div class="groupinfo">
                    <h4><?= Html::encode("{$group->groupname}") ?></h4>
                    <p>Created on <?= Html::encode("{$group->create_date}") ?></p>
                    <p style="text-align:left;"><?php 
                        $content = $group->descripton;
                        if(strlen($content) > 150)
                        {
                            $content = substr($group->descripton, 1, 80) . '...';
                        }
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

    <?= LinkPager::widget(['pagination' => $paginationMyGroup]) ?>
</div>

<?php } else {?>
    <div class="no-group">
        <h2>No Group is created!</h2>
    </div>
    <?php }?>

<?php if(count($joinedGroups)>0) { ?>
<div>
    
    <h3>Joined Groups</h3>
    <ul class="groups">
    <?php foreach ($joinedGroups as $group): ?>
        <li><div class="group">
                <div style="text-align:center;">
                    <h4><?= Html::encode("{$group->groupname}") ?></h4>
                    <p>Created on <?= Html::encode("{$group->create_date}") ?></p>
                </div>
                <div style="text-align: center;">
                    <?= Html::submitButton('Leave', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </li>
    <?php endforeach; ?>

    <?= LinkPager::widget(['pagination' => $paginationJoinedGroup]) ?>
</div>

<?php }?>