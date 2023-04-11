<?php
require "components/db.php";
$code=$_GET["code"];

$codes = [];


$sql = "SELECT * FROM `code` WHERE `code` = ? ORDER BY id DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute([$code]);
while($row = $stmt->fetch())
{
    ${'user' . $row['id']} = new stdClass();
    ${'user' . $row['id']}->code = $row["code"];
    ${'user' . $row['id']}->time = $row["time"];
    ${'user' . $row['id']}->id = $row["id"];
    ${'user' . $row['id']}->date = $row["date"];
    ${'user' . $row['id']}->email = $row["email"];
    ${'user' . $row['id']}->expire = $row["expire"];
    array_push($codes,${'user' . $row['id']});
}
echo json_encode($codes);