<?php
require_once ('safe_validate.php');
require_once ('safe_filter.php');
require_once ('connection.php');

$from_uid = $_POST['from_uid'];
$to_uid = $_POST['to_uid'];
$timestamp = mktime();

mysql_query("INSERT INTO friends (from_uid,to_uid,status,updated) VALUES ($from_uid,$to_uid,0,$timestamp)");

echo 1;