<?php
use yii\helpers\Html;
?>
<?php
$this->title = 'Signed Up';
?>
<h2> You have Signed up successfully! </h2>
<p>Account Info:</p>
<ul>
    <li><label>First Name</label>: <?= Html::encode($model->f_name) ?></li>
	<li><label>Last Name</label>: <?= Html::encode($model->l_name) ?></li>
	<li><label>Username</label>: <?= Html::encode($model->username) ?></li>
    <li><label>Email</label>: <?= Html::encode($model->email) ?></li>
</ul>
