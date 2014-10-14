<?php
require_once ('safe_filter.php');
require_once ('safe_validate.php');
require_once ('connection.php');
require_once ('upload_dir.php');

if(isset($_POST['qid'])){
    include ('poll_get_with_id.php');
}elseif(isset($_POST['exist_array'])){
    include ('poll_get_shuffle.php');
}elseif(isset($_POST['order_number'])){
    include ('poll_get_multiorder.php');
}else{
    echo 0;
}