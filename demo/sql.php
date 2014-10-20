<?php
$dbh = new PDO('mysql:host=localhost;dbname=demo2', 'root', '123456');    
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
$dbh->exec('set names utf8');   

?>