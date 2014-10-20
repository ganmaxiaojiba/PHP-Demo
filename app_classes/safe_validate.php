<?php
if(!isset($_POST['client_time'])||!isset($_POST['client_validate'])){
    exit("非法的数据源！");
}
$client_time = $_POST['client_time'];
$client_validate = $_POST['client_validate'];
$current_time = mktime();
$server_validate = hash("sha1",hash("sha1",md5($client_time)));

$time_check = abs($current_time - $client_time);
if($time_check>=1800){
    exit("非法的数据源！");
}elseif(!($client_validate==$server_validate)){
    exit("非法的数据源！");
}