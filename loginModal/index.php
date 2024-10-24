<!doctype html>
<html lang="en">
  <head>
  	<title>Modal 02</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
	
		<link rel="stylesheet" href="css/ionicons.min.css">
		<link rel="stylesheet" href="css/modalstyle.css">
		
  <style>
    /* Override and enhance styles */
    .modal-content {
      background-color: #f8f9fa !important;
      border-radius: 10px !important;
      box-shadow: 0 0 30px rgba(0, 0, 0, 0.1) !important;
      padding: 20px !important;
    }

    .modal-header {
      border-bottom: none !important;
      position: relative !important;
    }

    .modal-header .close {
      position: absolute !important;
      top: 10px !important;
      right: 10px !important;
      font-size: 20px !important;
    }

    .modal-body {
      padding: 20px !important;
    }

    h3 {
      font-family: 'Poppins', sans-serif !important;
      font-weight: 600 !important;
      color: #333 !important;
    }

    .form-control {
      border-radius: 5px !important;
      border: 1px solid #ced4da !important;
      padding: 10px !important;
      font-family: 'Poppins', sans-serif !important;
      margin-bottom: 15px !important;
    }

    .btn-primary {
      background-color: #007bff !important;
      border-color: #007bff !important;
      font-family: 'Poppins', sans-serif !important;
      font-weight: 600 !important;
    }

    .form-check .fill-control-description {
      color: #666 !important;
    }

    .form-check .fill-control-description:hover {
      color: #666 !important;
    }

    .form-group.text-center p {
      color: #666 !important;
      font-family: 'Poppins', sans-serif !important;
    }

    .form-group.text-center p a {
      color: #007bff !important;
      text-decoration: none !important;
    }

    .form-group.text-center p a:hover {
      text-decoration: underline !important;
    }

    /* Ensure no other styles conflict */
    .modal-content *,
    .modal-content *::before,
    .modal-content *::after {
      box-sizing: border-box !important;
    }
	input:-webkit-autofill {
    background-color: #fff !important;
    color: #000 !important;
	}
  </style>
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
      <div class="modal-body">
        <div id="sign-up-section">
          <h3 class="mb-4">Sign Up</h3>
          <form action="secure_signup.php" class="signup-form" method='post' autocomplete="off">
		  
		    <!-- <legend>Personal Information</legend> -->
            <div class="form-group">
              <label for="u_name">Username</label>
              <input type="text" class="form-control" name="u_name" id="u_name" placeholder="Username" autocomplete="off" required>
            </div>
            <div class="form-group">
              <label for="email">Email Address</label>
              <input type="email" class="form-control" name="email" id="email" placeholder="Email address" autocomplete="off" required>
            </div>
            <div class="form-group">
              <label for="pass_key">Password</label>
              <input type="password" class="form-control" name="pass_key" id="pass_key" placeholder="Password" autocomplete="off" required>
            </div>
            <!-- <legend>Account Details</legend> -->
            <input type="hidden" class="form-control" name="hasApproved" id="textfield" value="Not Yet">
            <div class="form-group">
              <input type="hidden" class="form-control" name="address_id" id="address_id" placeholder="Address ID" value="<?php $randomNumber = mt_rand(1, 1000000000); echo $randomNumber;?>" readonly required/>
            </div>
            <div class="form-group">
              <input type="hidden" class="form-control" name="h_id" id="h_id" placeholder="Health ID" value="<?php $randomNumber = mt_rand(1, 1000000000); echo $randomNumber;?>" readonly required/>
            </div>
            <div class="form-group">
              <input type="hidden" class="form-control" name="m_id" id="m_id" placeholder="Membership ID" value="<?php echo time(); ?>" readonly required/>
            </div>
            <div class="form-group">
              <button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign Up</button>
            </div>
            <div class="form-group text-center">
              <p>Already have an account? <a href="#" id="show-sign-in">Sign In</a></p>
            </div>
          </form>
        </div>

        <div id="sign-in-section" style="display:none;">
          <h3 class="mb-4">Sign In</h3>
          <form action="secure_login.php" class="signin-form" method='post' id="bb">
            <!--<legend>Login Information</legend>-->
            <div class="form-group">
              <label for="user_id_auth">Username</label>
              <input type="text" placeholder="Username" class="form-control" name="user_id_auth" id="user_id_auth" data-rule-minlength="6" data-rule-required="true" required>
            </div>
            <div class="form-group">
              <label for="pwfield">Password</label>
              <input type="password" name="pass_key" id="pwfield" class="form-control" data-rule-required="true" data-rule-minlength="6" placeholder="Password" required>
            </div>
            <div class="form-group">
              <button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign In</button>
            </div>
            <div class="form-group d-md-flex">
              <div class="form-check w-50">
                <label class="custom-control fill-checkbox">
                  <input type="checkbox" class="fill-control-input">
                  <span class="fill-control-indicator"></span>
                  <span class="fill-control-description">Remember Me</span>
                </label>
              </div>
              <div class="w-50 text-md-right">
                <a href="forgot_password.php" style="color: #0e0e0f!important">Forgot Password</a>
              </div>
              <div class="w-50 text-md-right">
                <a href="login-admin.php" style="color: #0e0e0f!important">I am an Admin/Coach</a>
              </div>
            </div>
            <div class="form-group text-center">
              <p>Don't have an account? <a href="#" id="show-sign-up">Sign Up</a></p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>





<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
<script>
  $(document).ready(function() {
    $('#show-sign-in').click(function(e) {
      e.preventDefault();
      $('#sign-up-section').hide();
      $('#sign-in-section').show();
    });

    $('#show-sign-up').click(function(e) {
      e.preventDefault();
      $('#sign-in-section').hide();
      $('#sign-up-section').show();
    });
  });
</script>
  </body>
</html>
