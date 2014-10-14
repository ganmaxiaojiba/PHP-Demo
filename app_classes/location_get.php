<?php
require_once ('safe_validate.php');
require_once ('safe_filter.php');
require_once ('connection.php');

$uid = $_POST['uid'];

$result = mysql_query("SELECT * FROM profile WHERE uid=$uid");
$row = mysql_fetch_array($result);

if($row){
$location_x = $row['location_x'];
$location_y = $row['location_y'];

$arr = array();
$arr[] = $location_x;
$arr[] = $location_y;

echo json_encode($arr);
}else{
    echo 0;
}