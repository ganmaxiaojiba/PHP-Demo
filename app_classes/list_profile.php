<?php
require_once ('safe_filter.php');
require_once ('safe_validate.php');
require_once ('connection.php');

$type = $_POST['type'];
$exist = $_POST['exist_number'];
$uid = $_POST['uid'];
$arr = array();

$list_result = mysql_query("SELECT qid FROM polls_records WHERE uid=$uid AND record_type=$type ORDER BY timestamp DESC LIMIT $exist,20");

while($list_row = mysql_fetch_array($list_result)){
    $qid = $list_row['qid'];
    $result = mysql_query("SELECT * FROM polls WHERE qid=$qid");
    $row = mysql_fetch_array($result);
    $sub_arr = array();
    $sub_arr[] = $row['qid'];
    $sub_arr[] = $row['title'];
    $sub_arr[] = $row['created'];
    $sub_arr[] = $row['total_votes'];
    $by_uid = $row['by_uid'];
    $user_result = mysql_query("SELECT * FROM user WHERE uid = $by_uid");
    $user_row = mysql_fetch_array($user_result);
    $sub_arr[] = $row['by_uid'];
    $sub_arr[] = $user_row['nickname'];
    $sub_arr[] = $avatarLargeOut.$user_row['avatar_large'];
    $sub_arr[] = $avatarSmallOut.$user_row['avatar_small'];
    $arr[] = $sub_arr;
}

echo json_encode($arr);