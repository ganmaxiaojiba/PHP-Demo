<?php
$current_version = 1;
$must_update_version = 1;

$version_get = $_POST['v_get'];
if($version_get==0){
    echo $current_version;
}else{
    echo $must_update_version;
}