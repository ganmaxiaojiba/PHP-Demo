<?php
require_once ('safe_filter.php');
$uid = $_POST['uid'];
$sql_query = "";
$sql_insert_title = "uid";
$sql_insert_value = $uid;
$nickname = $_POST['nickname'];

if(isset($_POST['sex'])||isset($_POST['birth'])||isset($_POST['education'])||isset($_POST['city'])||isset($_POST['signature'])){
    if(isset($_POST['sex'])){
        $sex = $_POST['sex'];
        $query = "sex=".$sex;
        $sql_query = $sql_query.$query.",";
        $sql_insert_title = $sql_insert_title.",sex";
        $sql_insert_value = $sql_insert_value.",".$sex;
    }
    if(isset($_POST['birth'])){
        $birth = $_POST['birth'];
        $query = "birth=".$birth;
        $sql_query = $sql_query.$query.",";
        $sql_insert_title = $sql_insert_title.",birth";
        $sql_insert_value = $sql_insert_value.",".$birth;
    }
    if(isset($_POST['education'])){
        $education = $_POST['education'];
        $query = "education=".$education;
        $sql_query = $sql_query.$query.",";
        $sql_insert_title = $sql_insert_title.",education";
        $sql_insert_value = $sql_insert_value.",".$education;
    }
    if(isset($_POST['city'])){
        $city = $_POST['city'];
        $query = "city='".$city."'";
        $sql_query = $sql_query.$query.",";
        $sql_insert_title = $sql_insert_title.",city";
        $sql_insert_value = $sql_insert_value.",'".$city."'";
    }
    if(isset($_POST['signature'])){
        $signature = $_POST['signature'];
        $query = "signature='".$signature."'";
        $sql_query = $sql_query.$query.",";
        $sql_insert_title = $sql_insert_title.",signature";
        $sql_insert_value = $sql_insert_value.",'".$signature."'";
    }

    require_once ('safe_validate.php');
    require_once ('connection.php');

    $result = mysql_query("SELECT * FROM profile WHERE uid = $uid");
    $row = mysql_fetch_array($result);
    $timestamp = mktime();
    
    if($row){
        mysql_query("UPDATE profile SET $sql_query updated=$timestamp WHERE uid = $uid");
        mysql_query("UPDATE user SET nickname='$nickname' WHERE uid=$uid");
        echo 1;
    }else{
        mysql_query("INSERT INTO profile ($sql_insert_title,updated) VALUES ($sql_insert_value,$timestamp)");
        mysql_query("UPDATE user SET nickname='$nickname' WHERE uid=$uid");
        echo 1;
    }
}else{
    echo 0;
}