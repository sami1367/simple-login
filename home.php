<?php require_once 'assets/config.php' ?>
<!DOCTYPE html>
<html>
<head>
<title>simple login</title>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> 
</head>

<?php
session_start();
$userEmail = clean($_SESSION['email']);
$userToken = clean($_SESSION['token']);
$result = mysqli_query($conn, "select * from users where email='$userEmail' and token='$userToken' order by id desc limit 1");
$user =  mysqli_fetch_assoc($result);
if(!$user){
    header("Location: index.php");
exit();
}
?>


<h1>Home</h1>
<h2>Welcome " <?php echo ($user['name']); ?> "</h2>

<a href="" onclick="logout();">Log out</a>

</body>
<script>

function logout() {
  $.ajax({
    type: "POST",
    url: "assets/logout.php",
    data: {

    }
    }).done(function(msg) {
        window.location.href = "index.php";
        if (msg.success==true) {

        }else{

        }
  });
  
}

</script>

</html> 
