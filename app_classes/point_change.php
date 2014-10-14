<?php
require_once ('safe_validate.php');
require_once ('safe_filter.php');
require_once ('connection.php');

$uid = $_POST['uid'];
$points = $_POST['points'];
$type = $_POST['type'];
$timestamp = mktime();

mysql_query("UPDATE profile SET point = point+$points WHERE uid=$uid");
mysql_query("INSERT INTO point_record (uid,point_change,type,timestamp) VALUES ($uid,$points,$type,$timestamp)");

echo 1;