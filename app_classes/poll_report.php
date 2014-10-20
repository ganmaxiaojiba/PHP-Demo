<?php
require_once ('safe_filter.php');
require_once ('safe_validate.php');
require_once ('connection.php');
$qid = $_POST['qid'];
$uid = $_POST['uid'];
$timestamp = mktime();

mysql_query("INSERT INTO reported (qid,uid,timestamp) VALUES ($qid,$uid,$timestamp)");

echo 1;