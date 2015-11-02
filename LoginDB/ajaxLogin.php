<?php
include("db.php");
session_start();
if (isset($_POST['username']) && isset($_POST['password']))
{
    $result = "SELECT uid FROM users WHERE username=:un AND password=:pw";
    $stmt   = $dbc->prepare($result);
    $stmt->bindParam(':un', $_POST['username']);
    $stmt->bindParam(':pw', $_POST['password']);
    $stmt->execute();
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($row > 0){
        $_SESSION['login_user'] = $row['uid'];
        echo $row['uid'];
    }
}
?>
