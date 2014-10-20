<?php
require_once ('safe_filter.php');
$username = $_POST['username'];
$password = $_POST['password'];
$nickname = $_POST['nickname'];

require_once ('safe_validate.php');
require_once ('connection.php');
require_once ('upload_dir.php');

$username_check = mysql_query("SELECT * FROM user WHERE username like '$username'");
$username_row = mysql_fetch_array($username_check);
$nickname_check = mysql_query("SELECT * FROM user WHERE nickname like '$nickname'");
$nickname_row = mysql_fetch_array($nickname_check);

if($username_row){
    echo 2;
}elseif($nickname_row){
    echo 1;
}else{
	$timestamp = mktime();
	$password = hash('sha512',$password);
	mysql_query("INSERT INTO user (username, password, created, nickname, last_login) VALUES ('$username','$password','$timestamp','$nickname','$timestamp')");
	$uid_new = mysql_insert_id();
	
        //echo $uid_new;
        $avatar_source = "default-".$avatar_rand.".png";
        $avatar_taget = $uid_new."@2x.png";

        copy($avatarLarge.$avatar_source,$avatarLarge.$avatar_taget);
        copy($avatarSmall.$avatar_source,$avatarSmall.$avatar_taget);
        
        mysql_query("INSERT INTO user_records (uid,user_votes,user_friends,user_comments,user_posts,updated) VALUES ('$uid_new',0,0,0,0,'$timestamp')");
        mysql_query("INSERT INTO profile (uid,sex,birth,education,city,signature,point,location_x,location_y,updated) VALUES ('$uid_new',0,0,0,'未填','',0,999,999,'$timestamp')");
        mysql_query("UPDATE user SET avatar_large='$avatar_taget',avatar_small='$avatar_taget' WHERE uid=$uid_new");
        
        echo $uid_new;
}