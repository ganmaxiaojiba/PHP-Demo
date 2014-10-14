<?php
require_once ('safe_filter.php');
require_once ('safe_validate.php');
require_once ('connection.php');

$uid = $_POST['uid'];
$password = $_POST['password'];

$password_hashed = hash('sha512',$password);

mysql_query("UPDATE user SET password='$password_hashed' WHERE uid=$uid");

echo 1;