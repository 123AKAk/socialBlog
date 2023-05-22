<?php
require "components/db.php";

$code=$_POST["code"];
// $email="favour@gmail.com";
$email=$_POST["email"];
$time=$_POST["time"];
$date=$_POST["date"];

// check if the email used is in the database already
$sql = "SELECT * FROM `user` WHERE `email` = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$email]);

$error_handling = 1;// used to collect data about a certain error in the app
if($row = $stmt->fetch())
{
    $error_handling = 1;
}
else{
    $error_handling = 2;
}

if ($error_handling == 1) {
    $sql = "INSERT INTO `code`(`email`, `code`, `time`, `date`) VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $newpass = password_hash($password, PASSWORD_DEFAULT);
    $stmt->execute([$email,$code,$time,$date]);
    echo 1;
}
else{
    echo 2;
}
