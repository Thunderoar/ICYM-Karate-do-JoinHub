<?php

session_start();
if(isset($_SESSION["user_data"]))
{
	header("location:./dashboard/admin/");
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>ICYM Karate-Do Join-Hub | Login</title>
	<link rel="stylesheet" href="./css/style.css"/>
	<link rel="stylesheet" type="text/css" href="./css/entypo.css">
</head>
<style>
h2 {
  color:white;
background-image: url("blaze_back_new.png");
width: 1366px;
align-items: center;
}
</style>
<!-- hello -->
<body>
    <center><h2 style="color:#7CFC00;font-size:15px"><BR><BR><BR>WELCOME TO <BR>ICYM Karate-Do Join-Hub! <BR><BR><BR></h2></center>
<body class="page-body login-page login-form-fall">
    
    	<div id="container">
			<div class="login-container">
	
	<div>
		
		<div class="login-content">
		<h1 style="color:#ffffff" >Member Login</h1>
			<!--
			<a href="#" class="logo">
				<img src="logo1.png" alt="" />
			</a>
			<p class="description">Dear user, log in to access the admin area!</p>
			-->

			<!-- progress bar indicator -->
			<div class="login-progressbar-indicator">
				<h3>43%</h3>
				<span>logging in...</span>
			</div>
		</div>
		
	</div>
	
	<div class="login-progressbar">
		<div></div>
	</div>
	
	<div class="login-form">
		
		<div class="login-content">
			
			<form action="secure_login.php" method='post' id="bb">				
				<div class="form-group">					
					<div class="input-group">
						<div class="input-group-addon">
							<i class="entypo-user"></i>
						</div>
							<input type="text" placeholder="User ID" class="form-control" name="user_id_auth" id="textfield" data-rule-minlength="6" data-rule-required="true">
					</div>
				</div>				
								
				<div class="form-group">					
					<div class="input-group">
						<div class="input-group-addon">
							<i class="entypo-key"></i>
						</div>
						<input type="password" name="pass_key" id="pwfield" class="form-control" data-rule-required="true" data-rule-minlength="6" placeholder="Password">
					</div>				
				</div>
				
				<div class="form-group">
					<button type="submit" name="btnLogin" class="btn btn-primary">
						Login In
						<i class="entypo-login"></i>
					</button>
				</div>
			</form>
		
				<div>
					<a style="color:#ffffff" href="forgot_password.php" class="link">Forgot your password?</a>
				</div>
				<div>
					<a style="color:#ffffff" 	href="register-member.php" class="link">Not yet a member?</a>
				</div>
				<div style="margin-top:5px">
					<a style="color:#ffffff" 	href="login.php" class="link">Admin? Go here</a>
				</div>
		</div>
		
	</div>
	
</div>

		</div>

</body>
</html>
