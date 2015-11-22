<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>

<?php if(count($searchedGroups)>0) { ?>
<div>
    <h2 style="margin-left: 5%;">My Groups</h2>
    <ul class="groupsls">
    <?php foreach ($searchedGroups as $group): ?>
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
        <h2>No Group is found!</h2>
    </div>
<?php }?>
