<?php
require ('config.php');
$email = clean($_REQUEST['email']);


$user = array();
$result = mysqli_query($conn, "select * from users where email='$email' order by id desc limit 1");
while ($row = mysqli_fetch_array($result)) {
    array_push($user, $row);
}
if(count ($user) > 0){
    $response = [
        'success'=>false,
        'err'=>"you had"
    ];
}else{
    $response = checkLastOtp($conn,$email);
}

function checkLastOtp($conn,$email){
    $response = "1";

    $lastOtp = array();
    $result = mysqli_query($conn, "select * from otp where email='$email' and `expire_at` > NOW() order by id desc limit 1");
    while ($row = mysqli_fetch_array($result)) {
        array_push($lastOtp, $row);
    }
    if($lastOtp[0]['fail']>=3 ){
        $response = [
            'success'=>false,
            'err'=>"after"
        ];
    }else if($lastOtp[0]){
        $response = [
            'success'=>true,
            'otp'=>$lastOtp[0]['code']
        ];
    }else{
        $code = generateRandomString();
        $res = mysqli_query($conn, "insert into otp set email='$email',code='$code',expire_at=DATE_ADD(NOW(), INTERVAL '5:0' MINUTE_SECOND)");
        if ($res != "") {
            $response = [
                'success'=>true,
                'otp'=>$code
            ];
        } else {
            $response = [
                'success'=>false,
                'err'=>"no"
            ];
        }
    }
    return $response;
}


header('Content-Type: application/json');
echo json_encode($response);

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