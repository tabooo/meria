<?php
include("config.php");
if (@$_SESSION['username']!=""){

		refreshPage(0, "index");
	
die();
}
mysqlconnect();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>მერია Login</title>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	<style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
	 <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </head>
  <body width="">
  <script type="text/javascript" >
function login(){ 
					var username = $('#username').val();
					var password = $('#password').val();
					$('#sublogin').addClass("disabled");
                    $.post('php.php',{dos:"login",username:username,password:password}, function(data){
						$("#report").html(data);
						$('#sublogin').removeClass("disabled")
						//document.getElementById("error").style.visibility="visible";
						//alert(username+password);
                    });
                    return false;
                }
           
			
if (document.layers) {
  document.captureEvents(Event.KEYDOWN);
}

document.onkeydown = function (evt) {
  var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
  if (keyCode == 13) {
    $('#sublogin').click();
  }
  if (keyCode == 27) {
    // For Escape.
    // Your function here.
  } else {
    return true;
  }
};
</script>
<div class="container">

      <form class="form-signin">
        <h2 class="form-signin-heading">ავტორიზაცია</h2>
        <input type="text" class="input-block-level" id="username" placeholder="მომხმარებლის სახელი" autofocus>
        <input type="password" class="input-block-level" id="password" placeholder="პაროლი">
        <button type="button"  class="btn btn-large btn-primary" id="sublogin" onclick="login()" data-loading-text="Loading...">შესვლა</button>
		<br><br><div class="report" id="report"></div>
      </form>

    </div>


  </body>
</html>