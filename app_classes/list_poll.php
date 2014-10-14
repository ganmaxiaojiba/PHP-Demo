<?php
require_once ('safe_filter.php');
require_once ('safe_validate.php');
require_once ('connection.php');
require_once ('upload_dir.php');

$list_type=$_POST['list_type'];
$arr = array();
// 1：最新 2：最热 3：圈内

if($list_type==1){
    if(isset($_POST['more_from'])){
        $more_from=$_POST['more_from'];
        $result = mysql_query("SELECT * FROM polls WHERE status=1 ORDER BY created DESC LIMIT $more_from,10");
    }else{
        $result = mysql_query("SELECT * FROM polls WHERE status=1 ORDER BY created DESC LIMIT 20");
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
}elseif($list_type==2){
        if(isset($_POST['more_from'])){
        $more_from=$_POST['more_from'];
        $result = mysql_query("SELECT * FROM polls WHERE status=1 ORDER BY total_votes DESC LIMIT $more_from,10");
    }else{
        $result = mysql_query("SELECT * FROM polls WHERE status=1 ORDER BY total_votes DESC LIMIT 20");
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
}elseif($list_type==3){
    $uid = $_POST['uid'];
    $count_result = mysql_query("SELECT COUNT(*) FROM friends WHERE from_uid=$uid AND status=1");
    $count_row = mysql_fetch_array($count_result);
    if($count_row[0]>0){
        $friends_filter = "";
        $i = 0;
        $friend_result = mysql_query("SELECT * FROM friends WHERE from_uid=$uid AND status=1");
        while($friend_row=  mysql_fetch_array($friend_result)){
            $to_uid = $friend_row['to_uid'];
            if($i==0){
                $friends_filter = "uid=".$to_uid;
            }else{
                $friends_filter = $friends_filter." OR uid=".$to_uid;
            }
        }
        if(isset($_POST['more_from'])){
            $more_from=$_POST['more_from'];
            $friends_poll_result = mysql_query("SELECT * FROM polls_records WHERE $friends_filter ORDER BY timestamp DESC LIMIT $more_from,10");
        }else{
            $friends_poll_result = mysql_query("SELECT * FROM polls_records WHERE $friends_filter ORDER BY timestamp DESC LIMIT 20");
        }
        while($frineds_poll_row=mysql_fetch_array($friends_poll_result)){
            $qid = $frineds_poll_row['qid'];
            $result = mysql_query("SELECT * FROM polls WHERE qid=$qid");
            $row = mysql_fetch_array($result);
            $sub_arr = array();
            $sub_arr[] = $row['qid'];
            $sub_arr[] = $row['title'];
            $sub_arr[] = $frineds_poll_row['timestamp'];
            $sub_arr[] = $row['total_votes'];
            $uid = $frineds_poll_row['uid'];
            $user_result = mysql_query("SELECT * FROM user WHERE uid = $uid");
            $user_row = mysql_fetch_array($user_result);
            $sub_arr[] = $uid;
            $sub_arr[] = $user_row['nickname'];
            $sub_arr[] = $avatarLargeOut.$user_row['avatar_large'];
            $sub_arr[] = $avatarSmallOut.$user_row['avatar_small'];
            $sub_arr[] = $frineds_poll_row['record_type'];
            $arr[] = $sub_arr;
        }
    }else{
        $arr[] = 1;
    }
    echo json_encode($arr);
}else{
    echo 0;
}