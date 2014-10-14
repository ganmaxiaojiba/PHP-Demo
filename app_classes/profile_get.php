<?php
require_once ('safe_filter.php');
$uid = $_POST['uid'];

require_once ('safe_validate.php');
require_once ('connection.php');

$result = mysql_query("SELECT * FROM profile WHERE uid = $uid");
$row = mysql_fetch_array($result);

    $arr = array();
    $arr[] = $uid;
    $arr[] = $row['sex'];
    $arr[] = $row['birth'];
    $arr[] = $row['education'];
    $arr[] = $row['city'];
    $arr[] = $row['signature'];
    $arr[] = $row['point'];
    
$record_result = mysql_query("SELECT * FROM user_records WHERE uid = $uid");
$record_row = mysql_fetch_array($record_result);

    $arr[] = $record_row['user_votes'];
    $arr[] = $record_row['user_posts'];
    $arr[] = $record_row['user_comments'];
    $arr[] = $record_row['user_friends'];
    

echo json_encode($arr);