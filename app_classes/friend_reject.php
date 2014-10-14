<?php
require_once ('safe_validate.php');
require_once ('safe_filter.php');
require_once ('connection.php');

//User Id
$from_uid = $_POST['from_uid'];
//Target User Id
$to_uid = $_POST['to_uid'];

mysql_query("DELETE FROM friends WHERE from_uid=$to_uid AND to_uid=$from_uid");

echo 1;