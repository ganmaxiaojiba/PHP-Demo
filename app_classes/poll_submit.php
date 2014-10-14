<?php
require_once ('safe_filter.php');
require_once ('safe_validate.php');
require_once ('connection.php');
$qid = $_POST['qid'];
$oid = $_POST['oid'];
$voted = $_POST['voted'];
$uid = $_POST['uid'];
//$total_votes = 0;
$timestamp = mktime();

$resultPoll = mysql_query("SELECT * FROM polls WHERE qid = $qid");
$rowPoll = mysql_fetch_array($resultPoll);
if($rowPoll){
    //$total_votes = $rowPoll['total_votes'];
}else{
    exit();
    echo 0;
}
$oid_arr = json_decode($oid);
foreach($oid_arr as $oid_line){
    //$option_votes = 0;
    $resultOption = mysql_query("SELECT * FROM polls_options WHERE oid = $oid_line");
    $rowOption = mysql_fetch_array($resultOption);
    if($rowOption){
        //$option_votes = $rowOption['votes'];
    }else{
        exit();
        echo 0;
    }
    //$option_votes = $option_votes+1;
    mysql_query("UPDATE polls_options SET votes=votes+1 WHERE oid=$oid_line");
    mysql_query("INSERT INTO polls_records (uid,qid,oid,record_type,timestamp) VALUES ($uid,$qid,$oid_line,1,$timestamp)");
}



//$total_votes = $total_votes+1;
mysql_query("UPDATE polls SET total_votes=total_votes+1 WHERE qid=$qid");
mysql_query("UPDATE user_records SET user_votes=user_votes+1,updated=$timestamp WHERE uid=$uid");

echo 1;