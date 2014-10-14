<?php
require_once ('safe_filter.php');
require_once ('safe_validate.php');
require_once ('connection.php');
require_once ('upload_dir.php');

$tid = $_POST['tid'];

if(isset($_POST['more_from'])){
    $more_from=$_POST['more_from'];
    $result = mysql_query("SELECT * FROM polls WHERE status=1 AND type=$tid ORDER BY created DESC LIMIT $more_from,10");
}else{
    $result = mysql_query("SELECT * FROM polls WHERE status=1 AND type=$tid ORDER BY created DESC LIMIT 20");
}
while($row=mysql_fetch_array($result)){
    $sub_arr = array();
    $sub_arr[] = $row['qid'];
    $sub_arr[] = $row['title'];
    $sub_arr[] = $row['created'];
    $sub_arr[] = $row['total_votes'];
    $by_uid = $row['by_uid'];
    $user_result = mysql_query("SELECT * FROM user WHERE uid = $by_uid");
    $user_row = mysql_fetch_array($user_result);
    $sub_arr[] = $row['by_uid'];
    $sub_arr[] = $user_row['nickname'];
    $sub_arr[] = $avatarLargeOut.$user_row['avatar_large'];
    $sub_arr[] = $avatarSmallOut.$user_row['avatar_small'];
    $arr[] = $sub_arr;
}
echo json_encode($arr);