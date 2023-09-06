<?php

include_once('userFunction.php');

$result = userRegistration($_POST['username'],$_POST['useremail'],$_POST['userpassword'],$_POST['userphone'],$_POST['usernic']);
echo($result);
?>