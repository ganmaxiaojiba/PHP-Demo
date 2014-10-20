<?php
require_once ('safe_filter.php');
$uid = $_POST['uid'];

require_once ('safe_validate.php');
require_once ('connection.php');

$result = mysql_query("SELECT * FROM user WHERE uid = $uid");
$row = mysql_fetch_array($result);
if($row){
   $nickname = $row['nickname'];
   echo $nickname;
}else{
    echo 0;
}