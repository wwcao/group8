<?php
use yii\helpers\Html;
?>
<?php
$this->title = 'Login Successfully';
if($message=="")
{
   $message = "Param \$messgae is Empty!";
} 

echo $message;
?>