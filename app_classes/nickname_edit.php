<?php
require_once ('safe_filter.php');
require_once ('safe_validate.php');
require_once ('connection.php');

$uid = $_POST['uid'];
$nickname = $_POST['nickname'];

mysql_query("UPDATE user SET nickname='$nickname' WHERE uid=$uid");

echo 1;