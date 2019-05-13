<?php require_once 'assets/config.php' ?>
<?php
session_start();
$userEmail = $_SESSION['email'];
$userToken = $_SESSION['token'];
$result = mysqli_query($conn, "select * from users where email='$userEmail' and token='$userToken' order by id desc limit 1");
$user =  mysqli_fetch_assoc($result);
if($user){
    header("Location: home.php");
exit();
}
?>
<!DOCTYPE html>
<html>
<head>

<title>simple login</title>

 <!-- Latest compiled and minified CSS -->
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> 

<!-- our style -->
<link rel="stylesheet" href="assets/style.css">

</head>
<body>

<form id="regForm" action="/home.php" method="post">
  <!-- One "tab" for each step in the form: -->
  <div class="tab">
    <h1>Login or Register</h1>
    <p>Login:</p>
    <p><input placeholder="Email" name="oEmail" type="email"></p>
    <p><input placeholder="Password..." name="oPass" type="password"></p>
    <p style="color: red;" id="demo3"></p>
    <div style="overflow:auto;">
        <div style="float:right;">
            <button type="button" id="nextBtn" onclick="login(oEmail.value,oPass.value);">Login</button>
            or
            <button type="button" id="prevBtn" onclick="nextPrev(1)">Register now</button>
        </div>
    </div>
  </div>
  <div class="tab">
    <h1>Email</h1>
    <p>insert your email address :</p>
    <p><input type="email" placeholder="example@example.com" name="email" required></p>
    <p style="color: red;" id="demo"></p>
    <div style="overflow:auto;">
        <div style="float:right;">
            <button type="button" id="nextBtn" onclick="nextPrev(-1)">Login</button>
            or
            <button type="button" id="prevBtn" onclick="get_otp(email.value);">Register nowwwwwww</button>
        </div>
    </div>
  </div>
  <div class="tab">
    <h1>Code</h1>
    <p>insert verification code :</p>
    <p><input placeholder="******" name="code" required></p>
    <p>code sent to : <b style="color: green;" id="emailval"></b></p>
    <p style="color: red;" id="demo2"></p>
    <div style="overflow:auto;">
        <div style="float:right;">
            <button id="myBtn" class="btnDisable" disabled type="button" onclick="nextPrev(-1)"><b id="myTimer"></b> &nbsp;&nbsp;resend email</button>
            or
            <button type="button" id="prevBtn" onclick="check_otp(email.value,code.value);">Submit</button>
        </div>
    </div>
  </div>
  <div class="tab">
    <h1>Register</h1>
    <p>please insert your name and your new password</p>
    <p><input placeholder="name" name="nname"></p>
    <p><input placeholder="new password" name="npass" type="password"></p>
    <div style="overflow:auto;">
        <div style="float:right;">
            <button type="button" id="prevBtn" onclick="create(email.value,code.value,nname.value,npass.value);">Register now</button>
        </div>
    </div>
  </div>
  <!-- Circles which indicates the steps of the form: -->
  <div style="text-align:center;margin-top:40px;">
    <span class="step"></span>
    <span class="step"></span>
    <span class="step"></span>
    <span class="step"></span>
  </div>
</form>

</body>
<!-- our JavaScript -->
<script src="assets/index.js"></script>
</html> 