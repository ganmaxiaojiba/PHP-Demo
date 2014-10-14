<?php
require_once ('safe_filter.php');

$username = $_POST['username'];
$password = $_POST['password'];

require_once ('safe_validate.php');
require_once ('connection.php');
require_once ('upload_dir.php');

$result = mysql_query("SELECT * FROM user WHERE username like '$username'");
$row = mysql_fetch_array($result);
$uid = $row['uid'];

if($uid){
	$password_check = $row['password'];
	$password = hash('sha512',$password);
	if($password == $password_check){
		$timestamp = mktime();
		mysql_query("UPDATE user SET last_login = $timestamp WHERE uid = $uid");
                $arr = array();
                $arr[] = $row['uid'];
                $arr[] = $row['nickname'];
                $arr[] = $avatarLargeOut.$row['avatar_large'];
                $arr[] = $avatarSmallOut.$row['avatar_small'];
		echo json_encode($arr);
	}else{
		echo 0;
	}
}else{
	echo 0;
}