<?php
require_once ('safe_validate.php');
require_once ('safe_filter.php');
require_once ('connection.php');

//User Id
$from_uid = $_POST['from_uid'];
//Target User Id
$to_uid = $_POST['to_uid'];
$timestamp = mktime();

mysql_query("INSERT INTO friends (from_uid,to_uid,status,updated) VALUES ($from_uid,$to_uid,1,$timestamp)");
mysql_query("UPDATE friends SET status=1,updated=$timestamp WHERE from_uid=$to_uid AND to_uid=$from_uid");
mysql_query("UPDATE user_records SET user_friends=user_friends+1,updated=$timestamp WHERE uid=$to_uid OR uid=$from_uid");

echo 1;