<?php
// Connect Sever
$con = mysql_connect("localhost","5like2","KGuD9ZM7eyrfFENS");
if (!$con){
  exit("服务器连接错误！");
  }
// Connect DataBase
mysql_select_db("5like2", $con);

// Set Char SET
mysql_query("SET NAMES utf8");