<!doctype html>
<html lang="en">
  <head>
  	<title>Modal 02</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
	
		<link rel="stylesheet" href="css/ionicons.min.css">
		<link rel="stylesheet" href="css/modalstyle.css">
  </head>
  <body>
	<!-- disable button, button are being refered in the header.php instead
		<section class="ftco-section">
				<div class="row justify-content-center js-fullheight">
					<div class="col-md-6 text-center d-flex align-items-center">
						<div class="wrap w-100">
							<h2 class="mb-2">Modal 02</h2>
							<button type="button" class="btn btn-primary py-3 px-4" data-toggle="modal" data-target="#exampleModalCenter">
							  Launch Modal 02
							</button>

							 Modal 
						</div>
				</div>
			</div>
		</section>
		-->
		
		<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close d-flex align-items-center justify-content-center" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true" class="ion-ios-close"></span>
		        </button>
		      </div>
		      <div class="row">
			      <div class="col-md mb-md-0 mb-5">
				      <div class="modal-body p-0">
				      	<h3 class="mb-4">Sign In</h3>
				      	<form action="secure_login.php" class="signin-form" method='post' id="bb">
				      		<div class="form-group">
				      			<input  type="text" placeholder="Username" class="form-control" name="user_id_auth" id="textfield" data-rule-minlength="6" data-rule-required="true">
				      		</div>
			            <div class="form-group">
			              <input type="password" name="pass_key" id="pwfield" class="form-control" data-rule-required="true" data-rule-minlength="6" placeholder="Password">
			            </div>
			            <div class="form-group">
			            	<button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign In</button>
			            </div>
			            <div class="form-group d-md-flex">
			            	<div class="form-check w-50">
				            	<label class="custom-control fill-checkbox">
												<input type="checkbox" class="fill-control-input">
												<span style="color: #0e0e0f!important" class="fill-control-indicator"></span>
												<span style="color: #0e0e0f!important" class="fill-control-description">Remember Me</span>
											</label>
										</div>
										<div class="w-50 text-md-right">
											<a href="forgot_password.php" style="color: #0e0e0f!important">Forgot Password</a>
										</div>
										<div class="w-50 text-md-right">
											<a href="login-admin.php" style="color: #0e0e0f!important">I am an Admin/Coach</a>
										</div>
			            </div>
			          </form>
					  <!-- nope!
			          <p style="color: #0e0e0f!important" class="w-100 text-center">&mdash; Or Sign In With &mdash;</p>
			          <div class="social d-flex text-center">
			          	<a href="#" class="px-2 py-3 mr-md-1 rounded"><span class="ion-logo-facebook mr-2"></span> Facebook</a>
			          	<a href="#" class="px-2 py-3 ml-md-1 rounded"><span class="ion-logo-twitter mr-2"></span> Twitter</a>
			          </div>
						-->
				      </div>
				    </div>
					<!-- 
				    <div class="col-md-1 divider"></div>
				    <div class="col-md">
				      <div class="modal-body p-0">
				      	<h3 class="mb-4">Sign Up</h3>
				      	<form action="#" class="signup-form">
				      		<div class="form-group">
				      			<input type="text" class="form-control" placeholder="First Name">
				      		</div>
				      		<div class="form-group">
				      			<input type="text" class="form-control" placeholder="Last Name">
				      		</div>
				      		<div class="form-group">
				      			<input type="email" class="form-control" placeholder="Email address">
				      		</div>
				      		<div class="form-group">
			              <input type="password" class="form-control" placeholder="Password">
			            </div>
			            <div class="form-group">
			            	<button type="submit" class="form-control btn btn-primary rounded submit px-3">Login</button>
			            </div>
			            <div class="form-group">
										<div class="w-100">
											<p class="mb-0">By creating an account, your agree to our terms.</p>
										</div>
			            </div>
			          </form>
				      </div>
				    </div>
				  </div> -->
		    </div>
		  </div>
		</div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>
