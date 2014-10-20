<?php
require_once ('safe_filter.php');
require_once ('safe_validate.php');
require_once ('connection.php');
require_once ('upload_dir.php');

require_once ('comment_get_function.php');

$qid = $_POST['qid'];
$arr = array();

if(isset($_POST['more_number'])){
    $moreNumber = $_POST['more_number'];
    $arr = get_comment($qid,$moreNumber,$avatarSmallOut);
}else{
    $arr = get_comment($qid,0,$avatarSmallOut);
}

echo json_encode($arr);