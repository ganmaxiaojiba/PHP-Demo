<?php
require_once ('safe_validate.php');
require_once ('safe_filter.php');
require_once ('connection.php');
require_once ('upload_dir.php');

$uid = $_POST['uid'];
$arr = array();

$result = mysql_query("SELECT * FROM friends WHERE to_uid=$uid AND status=0");

while ($row = mysql_fetch_array($result)){
    $sub_arr = array();
    $from_uid = $row['from_uid'];
    $user_result = mysql_query("SELECT * FROM user WHERE uid = $from_uid");
    $profile_result = mysql_query("SELECT * FROM profile WHERE uid = $from_uid");
    $user_row = mysql_fetch_array($user_result);
    $profile_row = mysql_fetch_array($profile_result);
    $sub_arr[] = $row['from_uid'];
    $sub_arr[] = $user_row['nickname'];
    $sub_arr[] = $avatarLargeOut.$user_row['avatar_large'];
    $sub_arr[] = $avatarSmallOut.$user_row['avatar_small'];
    $sub_arr[] = $profile_row['sex'];
    $arr[] = $sub_arr;
}
echo json_encode($arr);