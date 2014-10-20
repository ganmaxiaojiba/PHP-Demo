<?php
require_once ('safe_filter.php');
require_once ('upload_dir.php');
$file_types = array('image/pjpeg','image/jpeg','image/jpg','image/gif','image/png','image/x-png');
$fileLarge = basename($_FILES['avatarLarge']['name']);
$fileSmall = basename($_FILES['avatarSmall']['name']);
$uid = $_POST['uid'];

if((in_array($_FILES['avatarLarge']['type'], $file_types))&&(in_array($_FILES['avatarSmall']['type'], $file_types))){
    if(($_FILES['avatarLarge']['error'] > 0)||($_FILES['avatarSmall']['error'] > 0)){
        echo 0;
    }else{
        $ext1 = pathinfo($fileLarge,PATHINFO_EXTENSION);
        $ext2 = pathinfo($fileSmall,PATHINFO_EXTENSION);
        
        $filenameLarge = $uid.'@2x.'.$ext1;
        $filenameSmall = $uid.'@2x.'.$ext2;
        
        move_uploaded_file($_FILES['avatarLarge']['tmp_name'],$avatarLarge.$filenameLarge);
        move_uploaded_file($_FILES['avatarSmall']['tmp_name'],$avatarSmall.$filenameSmall);
        
        require_once ('safe_validate.php');
        require_once ('connection.php');
        
        mysql_query("UPDATE user SET avatar_large = '$filenameLarge', avatar_small = '$filenameSmall' WHERE uid = $uid");
        
        echo 1;
    }
}else{
    echo 0;
}