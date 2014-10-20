<?php
require_once ('safe_filter.php');
require_once ('safe_validate.php');
require_once ('connection.php');

$uid = $_POST['uid'];
$qid = $_POST['qid'];
$text = $_POST['text'];
$timestamp = mktime();

mysql_query("INSERT INTO comments (qid,by_uid,content,created) VALUES ($qid,$uid,'$text',$timestamp)");
mysql_query("INSERT INTO polls_records (uid,qid,oid,record_type,timestamp) VALUES ($uid,$qid,0,3,$timestamp)");
mysql_query("UPDATE user_records SET user_comments=user_comments+1,updated=$timestamp WHERE uid=$uid");

echo 1;