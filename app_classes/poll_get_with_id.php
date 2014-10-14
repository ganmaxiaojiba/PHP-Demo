<?php

require_once ('comment_get_function.php');

    $qid = $_POST['qid'];
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
    
    $uid = $_POST["uid"];
    $had_polled = mysql_query("SELECT * FROM polls_records WHERE qid=$qid AND uid=$uid AND record_type=1 LIMIT 1");
    
    if($had_polled=  mysql_fetch_array($had_polled)){
        $pollArray[] = "1";
    }else{
        $pollArray[] = "0";
    }
    
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
    
    $polled_result = mysql_query("SELECT * FROM polls_records WHERE qid=$qid AND uid=$uid AND record_type=1");
    $polled_oid_array = array();
    while($polled_row = mysql_fetch_array($polled_result)){
        $polled_oid_array[] = $polled_row['oid'];
    }
    $pollArray[] = $polled_oid_array;
    
    echo json_encode($pollArray);