<?php
try
{
    $dbc = new PDO('mysql:host=localhost; dbname=userDB', 'root', '');
    $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $err)
{
    echo "Error: " . $err->getMessage();
}
?>
