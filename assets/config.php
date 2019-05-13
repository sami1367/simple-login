<?php

$server="localhost";
$user="root";
$pass="mahi6060";
$mydb="login";

$conn=new mysqli($server,$user,$pass,$mydb);

if ($conn->connect_error){
    echo "EEEEEEEEEEE";
    die("connection failed: ".$conn->connect_error);
}

$conn->query("SET NAMES UTF8");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function clean($data) {
    $data=trim($data);
    $data=stripcslashes($data);
    $data=htmlspecialchars($data);
    return $data;
}
?>
