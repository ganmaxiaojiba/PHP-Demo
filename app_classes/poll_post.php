<?php
require_once ('safe_filter.php');
require_once ('safe_validate.php');
require_once ('connection.php');
require_once ('upload_dir.php');

$file_types = array('image/pjpeg','image/jpeg','image/jpg','image/gif','image/png','image/x-png');
$uid = $_POST['uid'];
$have_picture = $_POST['have_picture'];
$have_title_picture = $_POST['have_tp'];
$title = $_POST['title'];
$option_amount = $_POST['option_amount'];
$choice_allow = $_POST['choice_allow'];
$otext = $_POST['otext'];
$otext_arr = json_decode($otext);
$timestamp = mktime();

mysql_query("INSERT INTO polls (title,status,type,by_uid,option_amount,choice_allow,total_votes,title_picture,created) VALUES ('$title','0','0','$uid','$option_amount','$choice_allow','0','0','$timestamp')");
$qid = mysql_insert_id();

if($have_title_picture==1){
    $tp_name = basename($_FILES['upload_tp']['name']);
    if(in_array($_FILES['upload_tp']['type'], $file_types)){
        if($_FILES[$uploadLarge]['error'] > 0){
            mysql_query("DELETE polls WHERE qid=$qid");
            echo 0;
            exit();
        }else{
            $ext_tp = pathinfo($tp_name,PATHINFO_EXTENSION);
            $filenameTP = $qid.'@2x.'.$ext_tp;
            
            move_uploaded_file($_FILES['upload_tp']['tmp_name'],$pollTopicImageLarge.$filenameTP);
            
            $original = imagecreatefrompng($pollTopicImageLarge.$filenameTP);
            $image_x = imagesx($original);
            $image_y = imagesy($original);
            $img=imagecreatetruecolor(250,250);
            imagecopyresampled($img, $original, 0, 0, 0, 0, 250, 250, $image_x, $image_y);
            imagejpeg($img,$pollTopicImageSmall.$filenameTP);
            
            mysql_query("UPDATE polls SET title_picture='$filenameTP' WHERE qid=$qid");
        }
    }else{
        mysql_query("DELETE polls WHERE qid=$qid");
        echo 0;
        exit();
    }

}

$i = 0;

foreach($otext_arr as $otext_line){
    if($have_picture==1){
        $uploadOption = "upload_option_".$i;
        $fileOption = basename($_FILES[$uploadOption]['name']);
        if(in_array($_FILES[$uploadOption]['type'], $file_types)){
            if($_FILES[$uploadOption]['error'] > 0){
                mysql_query("DELETE polls WHERE qid=$qid");
                echo 0;
                exit();
            }else{
                $extOption = pathinfo($fileOption,PATHINFO_EXTENSION);
                
                $filenameOption = $qid."-".$i.'@2x.'.$extOption;
                
                move_uploaded_file($_FILES[$uploadOption]['tmp_name'],$pollImageLarge.$filenameOption);

                mysql_query("INSERT INTO polls_options (qid,otext,votes,has_picture,image_large,image_small) VALUES ('$qid','$otext_line','0','1','$filenameOption','$filenameOption')");
                
                $original = imagecreatefrompng($pollImageLarge.$filenameOption);
                $image_x = imagesx($original);
                $image_y = imagesy($original);
                $img=imagecreatetruecolor(300,300);
                imagecopyresampled($img, $original, 0, 0, 0, 0, 300, 300, $image_x, $image_y);
                imagejpeg($img,$pollImageSmall.$filenameOption);
            }
        }else{
            mysql_query("DELETE polls WHERE qid=$qid");
            echo 0;
            exit();
        }
    }else{
        mysql_query("INSERT INTO polls_options (qid,otext,votes,has_picture) VALUES ('$qid','$otext_line','0','0')");
    }
    $i = $i+1;
}

if($i == $option_amount){
    echo 1;
}else{
    mysql_query("DELETE polls WHERE qid=$qid");
    echo 0;
    exit();
}

$superid_result = mysql_query("SELECT super_id FROM user WHERE uid=$uid");
$superid_row = mysql_fetch_array($superid_result);
$superid = $superid_row['super_id'];
if($superid==1){
    mysql_query("UPDATE polls SET status=1,managed_by=0,managed_time=$timestamp WHERE qid=$qid");
    mysql_query("UPDATE user_records SET user_posts=user_posts+1,updated=$timestamp WHERE uid=$uid");
    mysql_query("INSERT INTO polls_records (uid,qid,oid,record_type,timestamp) VALUES ($uid,$qid,0,2,$timestamp)");
}
