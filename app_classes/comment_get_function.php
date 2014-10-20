<?php

function get_comment($qid,$moreNumber,$avatarSmallOut){
    $comment_arr = array();
    $comment_result = mysql_query("SELECT * FROM comments WHERE qid=$qid ORDER BY created DESC LIMIT $moreNumber,10");
    while($comment_row = mysql_fetch_array($comment_result)){
        $comment_uid = $comment_row['by_uid'];
        $comment_user_result = mysql_query("SELECT * FROM user WHERE uid=$comment_uid");
        $comment_user_row = mysql_fetch_array($comment_user_result);
        $comment_sub_arr = array();
        $comment_sub_arr[] = $comment_row['cid'];
        $comment_sub_arr[] = $comment_row['content'];
        $comment_sub_arr[] = $comment_row['created'];
        $comment_sub_arr[] = $comment_row['by_uid'];
        $comment_sub_arr[] = $comment_user_row['nickname'];
        $comment_sub_arr[] = $avatarSmallOut.$comment_user_row['avatar_small'];
            
        $comment_arr[] = $comment_sub_arr;
    }
    return $comment_arr;
};