<?php
require_once ('safe_validate.php');
require_once ('safe_filter.php');
require_once ('connection.php');

//User Id
$from_uid = $_POST['from_uid'];
//Target User Id
$to_uid = $_POST['to_uid'];

$result_asked = mysql_query("SELECT * FROM friends WHERE from_uid=$from_uid AND to_uid=$to_uid");
$result_waiting = mysql_query("SELECT * FROM friends WHERE to_uid=$from_uid AND from_uid=$to_uid");

$row_asked = mysql_fetch_array($result_asked);
$row_waiting = mysql_fetch_array($result_waiting);

$status = $row_asked['status'];

if($status==1){
    //Already Friends
    echo 4;
}else{
    if($row_asked){
        //Already Asked
        echo 3;
    }elseif($row_waiting){
        //Been Asked to be a Friend
        echo 2;
    }else{
        //Nothing Between These Two
        echo 1;
    }
}