<?php
require ('config.php');
$otp = $_REQUEST['otp'];
$email = $_REQUEST['email'];
$lastOtp = array();
$result = mysqli_query($conn, "select * from otp where email='$email' and `expire_at` < DATE_ADD(NOW(), INTERVAL '5:0' MINUTE_SECOND) order by id desc limit 1");
while ($row = mysqli_fetch_array($result)) {
    array_push($lastOtp, $row);
}
if($lastOtp[0]['code']==$otp and $lastOtp[0]['fail']<3){
    print "yes";
}else if($lastOtp[0]['fail']>=3){
    print "after";
}else{
    $fail = (int)$lastOtp[0]['fail']+1;
    $id = (int)$lastOtp[0]['id'];
    print "no";
    $result = mysqli_query($conn, "update otp set fail=$fail where id=$id");
}
?>