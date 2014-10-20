<?php
require_once ('safe_validate.php');
require_once ('safe_filter.php');
require_once ('connection.php');

$uid = $_POST['uid'];
$location_x = $_POST['location_x'];
$location_y = $_POST['location_y'];
$timestamp = mktime();

mysql_query("UPDATE profile SET location_x=$location_x,location_y=$location_y,updated=$timestamp WHERE uid=$uid");

echo 1;