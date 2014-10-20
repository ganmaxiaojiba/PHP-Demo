<?php
require_once ('safe_filter.php');
require_once ('safe_validate.php');
require_once ('connection.php');
require_once ('upload_dir.php');

$uid = $_POST['uid'];

$result = mysql_query("SELECT * FROM user WHERE uid<>$uid");
$row = mysql_fetch_array($result);

while($row){
    
}