<?php
require ('config.php');
$email = clean($_REQUEST['email']);
$pass = clean($_REQUEST['pass']);

$result = mysqli_query($conn, "select * from users where email='$email' and pass='$pass' order by id desc limit 1");
$user =  mysqli_fetch_assoc($result);
if($user){
    $token = generateRandomString(64);
    $id = $user['id'];
    $res = mysqli_query($conn, "update users set token='$token' where id=$id");
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
}else{
    $response = [
        'success'=>false,
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