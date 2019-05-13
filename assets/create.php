<?php
require ('config.php');

$email = clean($_REQUEST['email']);
$nname = clean($_REQUEST['nname']);
$npass = clean($_REQUEST['npass']);
$otp = clean($_REQUEST['otp']);

$lastOtp = array();
$result = mysqli_query($conn, "select * from otp where email='$email' and `expire_at` < DATE_ADD(NOW(), INTERVAL '5:0' MINUTE_SECOND) order by id desc limit 1");
while ($row = mysqli_fetch_array($result)) {
    array_push($lastOtp, $row);
}
if($lastOtp[0]['code']==$otp and $lastOtp[0]['fail']<3){
    $token = generateRandomString(64);
    $res = mysqli_query($conn, "insert into users set email='$email',name='$nname',pass='$npass',token='$token'");
    if ($res != "") {
        session_start();
        $_SESSION['token']= $token;
        $_SESSION['email']= $email;
        $response = [
            'success'=>true,
            'access_token'=>$token
        ];
    } else {
        $response = [
            'success'=>false,
            'errore_code'=>1
        ];
    }
}else if($lastOtp[0]['fail']>=3){
    $response = [
        'success'=>false,
        'errore_code'=>2
    ];
}else{
    $fail = (int)$lastOtp[0]['fail']+1;
    $id = (int)$lastOtp[0]['id'];
    $result = mysqli_query($conn, "update otp set fail=$fail where id=$id");
    $response = [
        'success'=>false,
        'errore_code'=>3
    ];
}

header('Content-Type: application/json');
echo json_encode($response);

function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


?>