<?php
require_once ('safe_filter.php');
require_once ('safe_validate.php');
require_once ('connection.php');
require_once ('upload_dir.php');

//$more_number = $_POST['more_number'];

$result = mysql_query("SELECT * FROM topics WHERE status=1");
$arr = array();

while($row=  mysql_fetch_array($result)){
    $sub_arr = array();
    $sub_arr[] = $row['tid'];
    $sub_arr[] = $row['topic_name'];
    $sub_arr[] = $row['poll_amount'];
    $sub_arr[] = $pollTopicImage.$row['topic_picture'];
    $arr[] = $sub_arr;
}

echo json_encode($arr);