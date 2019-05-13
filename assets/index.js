var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  document.getElementById("demo").innerHTML = "";
  var x = document.getElementsByClassName("tab");
  x[currentTab].style.display = "none";
  currentTab = currentTab + n;
  if (currentTab >= x.length) {
    document.getElementById("regForm").submit();
    return false;
  }
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  for (i = 0; i < y.length; i++) {
    if (y[i].value == "") {
      y[i].className += " invalid";
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; 
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  x[n].className += " active";
}

var sec = 15;
var myTimer = document.getElementById('myTimer');
var myBtn = document.getElementById('myBtn');
function countDown() {
  if (sec < 10) {
    myTimer.innerHTML = "0" + sec;
  } else {
    myTimer.innerHTML = sec;
  }
  if (sec <= 0) {
    $("#myBtn").removeAttr("disabled");
    $("#myBtn").removeClass().addClass("btnEnable");
    $("#myTimer").fadeTo(2500, 0);
    myBtn.innerHTML = "Click Me for resends email";
    return;
  }
  sec -= 1;
  window.setTimeout(countDown, 1000);
}

function get_otp(email) {
  if (!validateEmail(email)) {
           document.getElementById("demo").innerHTML = "please enter valid email";
  } else {
           $.ajax({
              type: "POST",
              url: "assets/otp.php",
              data: {
                  email: email,
              }
              }).done(function(msg) {
                console.log(msg)
                if (msg.success==true) {
                  nextPrev(1) ;
                  countDown();
                  document.getElementById("emailval").innerHTML = email;
                  document.getElementById("demo5").innerHTML = "otp code is : "+msg.otp;
                }else{
                  switch(msg.err) {
                    case 'no':
                      document.getElementById("demo").innerHTML = "error";
                      break;
                    case 'after':
                      document.getElementById("demo").innerHTML = "try after 5 minute";
                      break;
                    default:
                      document.getElementById("demo").innerHTML = "server error";
                    } 
                }
            });
  } 
}

function check_otp(email,otp) {
  $.ajax({
    type: "POST",
    url: "assets/checkotp.php",
    data: {
      email: email,
      otp: otp,
    }
    }).done(function(msg) {
        console.log(msg)
        if (msg == 'yes') {
          nextPrev(1) ;
        }else if(msg == 'no'){
          document.getElementById("demo2").innerHTML = "wrong code";
        }else if(msg == 'after'){
          document.getElementById("demo2").innerHTML = "try after 5 minute";
        }else{
          document.getElementById("demo2").innerHTML = "server error";
        }
  });
  
}

function create(email,otp,nname,npass) {
  $.ajax({
    type: "POST",
    url: "assets/create.php",
    data: {
      email: email,
      otp: otp,
      nname: nname,
      npass: npass,
    }
    }).done(function(msg) {
        if (msg.success==true) {
          window.location.href = "home.php";
        }else{
          console.log("error code is : ",msg.errore_code);
        }
  });
  
}

function login(email,pass) {
  console.log("llllogiiin")
  $.ajax({
    type: "POST",
    url: "assets/login.php",
    data: {
      email: email,
      pass: pass,
    }
    }).done(function(msg) {
      console.log("ffff")
      console.log(msg)
        if (msg.success==true) {
          window.location.href = "home.php";
        }else{
          document.getElementById("demo3").innerHTML = "invalin username or password";
        }
  });
  
}

function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}

function validate() {
  var $result = $("#result");
  var email = $("#email").val();
  $result.text("");

  if (validateEmail(email)) {
    $result.text(email + " is valid :)");
    $result.css("color", "green");
  } else {
    $result.text(email + " is not valid :(");
    $result.css("color", "red");
  }
  return false;
}

$("#validate").on("click", validate);
