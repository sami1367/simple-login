<?php
require ('config.php');
$email = $_REQUEST['email'];


$user = array();

$result = mysqli_query($conn, "select * from users where email='$email' order by id desc limit 1");
while ($row = mysqli_fetch_array($result)) {
    array_push($user, $row);
}
if(count ($user) > 0){
    print "you had";
}else{
    checkLastOtp($conn,$email);
}

function checkLastOtp($conn,$email){
    $lastOtp = array();
    $result = mysqli_query($conn, "select * from otp where email='$email' and `expire_at` > NOW() order by id desc limit 1");
    while ($row = mysqli_fetch_array($result)) {
        array_push($lastOtp, $row);
    }
    if($lastOtp[0]['fail']>=3 ){
        print "after";
    }else if($lastOtp[0]){
        print "yes";
    }else{
        $code = generateRandomString();
        $res = mysqli_query($conn, "insert into otp set email='$email',code='$code',expire_at=DATE_ADD(NOW(), INTERVAL '5:0' MINUTE_SECOND)");
        if ($res != "") {
            print "yes";
        } else {
            print "no";
        }
    }
}

function generateRandomString() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 6; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


?>