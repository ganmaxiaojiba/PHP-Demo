<?php

$password = $_GET['password'];

$password = md5($password);

$password = hash('sha512',$password);

echo $password;