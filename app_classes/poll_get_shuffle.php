<?php

require_once ('comment_get_function.php');

    $uid = $_POST["uid"];
    $exist_array = $_POST['exist_array'];
    $exist = json_decode($exist_array);
    
    
    $qidList = mysql_query("SELECT qid FROM polls WHERE status=1 ORDER BY qid");
    $qidList_array = array();
    while($row = mysql_fetch_array($qidList)){
        $qidList_array[] = $row['qid'];
    }
    $polled = mysql_query("SELECT qid FROM polls_records WHERE uid=$uid AND record_type=1 ORDER BY qid");
    $polled_array = array();
    while($row = mysql_fetch_array($polled)){
        $polled_array[] = $row['qid'];
    }
    if($polled_array){
        $qidPool = array_diff($qidList_array, $polled_array);
    }else{
        $qidPool = $qidList_array;
    }
    if($exist){
        $qidPool = array_diff($qidPool,$exist);
    }else{
        $qidPool = $qidPool;
    }
    if($qidPool){
        $qid_key = array_rand($qidPool);
	$qid = $qidPool[$qid_key];
	$get_poll = mysql_query("SELECT * FROM polls WHERE qid=$qid");
	$polls_row = mysql_fetch_array($get_poll);
        
        $get_options = mysql_query("SELECT * FROM polls_options WHERE qid=$qid");
        $has_picture = 0;
        $options = array();
        while($options_row = mysql_fetch_array($get_options)){
            if($options_row['has_picture']==0){
                $has_picture=0;
                $optionArray = array();
                $optionArray[] = $options_row['oid'];
                $optionArray[] = $options_row['otext'];
                $optionArray[] = $options_row['votes'];
                $options[] = $optionArray;
            }else{
                $has_picture=1;
                $optionArray = array();
                $optionArray[] = $options_row['oid'];
                $optionArray[] = $options_row['otext'];
                $optionArray[] = $options_row['votes'];
                $optionArray[] = $pollImageLargeOut.$options_row['image_large'];
                $optionArray[] = $pollImageSmallOut.$options_row['image_small'];
                $options[] = $optionArray;
            }
        }
        $pollArray = array();
        $pollArray[] = $has_picture;
        $pollArray[] = $qid;
	$pollArray[] = $polls_row['title'];
        $by_uid = $polls_row['by_uid'];
        $pollArray[] = $by_uid;
        $pollArray[] = $polls_row['created'];
        $pollArray[] = $polls_row['option_amount'];
        $pollArray[] = $polls_row['choice_allow'];
        $pollArray[] = $polls_row['total_votes'];
        $pollArray[] = $options;
        
        $nickname_result = mysql_query("SELECT * FROM user WHERE uid = $by_uid");
        $nickname_row = mysql_fetch_array($nickname_result);
        $nickname = $nickname_row['nickname'];
        $pollArray[] = $nickname;
        
        $pollArray[] = get_comment($qid, 0,$avatarSmallOut);
        
        if($polls_row['title_picture']=='0'){
            $pollArray[] = '0';
        }else{
            $pollArray[] = $polls_row['title_picture'];
        }        
        
	echo json_encode($pollArray);
    }else{
        echo 1;
    }