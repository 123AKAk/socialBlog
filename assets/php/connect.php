<?php
 $host  = "localhost";
 $uname = "root";
 $password = "";
 $db = "macaeblog";

//  $db ='sam';
// $host ='localhost';
// $uname="root";
// $password = "";

 //set DSN
$dsn = "mysql:host=$host; dbname=$db";
//create instance
$conn = new PDO($dsn,$uname,$password);
$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);