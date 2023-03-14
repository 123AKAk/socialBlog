<?php
include("connect.php");
$email=$_POST["email"];
$password=$_POST["password"];
$newpass = password_hash($password, PASSWORD_DEFAULT);

$sql = "UPDATE `user` SET  `password`= ?  WHERE `email` = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$password,$email]);

$sql = "UPDATE `code` SET  `expire`= ?  WHERE `email` = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([0,$email]);
echo 1;// this means that averything is set