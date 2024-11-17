<!doctype html>
<html lang="en">
  <head>
  	<title>Modal 02</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900&v=<?php echo rand(); ?>" rel="stylesheet">
<link rel="stylesheet" href="css/ionicons.min.css?v=<?php echo rand(); ?>">
<link rel="stylesheet" href="css/modalstyle.css?v=<?php echo rand(); ?>">
<link rel="stylesheet" href="../font/flaticon/font/flaticon.css?v=<?php echo rand(); ?>">
<script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.8/inputmask.min.js"></script>




		
  <style>
    /* Override and enhance styles */
    .modal-content {
      background-color: #00003c !important;
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
      <!-- color: #333 !important;-->
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
      <!--color: #666 !important; -->
    }

    .form-check .fill-control-description:hover {
      <!--color: #666 !important;-->
    }

.form-group.text-center p {
  color: #FFFFFF
 !important; /* Apply your desired color */
  font-family: 'Poppins', sans-serif !important;
}

.form-group.text-center p:hover {
  color: #FFFFFF
 !important; /* Same as the default state */
}


    .form-group.text-center p a {
      color: #007bff !important;
      text-decoration: none !important;
    }

    .form-group.text-center p a:hover {
      <!-- text-decoration: underline !important; -->
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
		
	/* Add a green text color and a checkmark when the requirements are right */
	.valid {
	color: green;
	}
	.valid:before {
	position: relative;
	left: -35px;
	content: "✔";
	}
	/* Add a red text color and an "x" when the requirements are wrong */
	.invalid {
	color: red;
	}
	.invalid:before {
	position: relative;
	left: -35px;
	content: "✖";
	}
	/* The message box is shown when the user clicks on the password field */
	#message {
	display:none;
	background: #f1f1f1;
	color: #000;
	position: relative;
	padding: 10px;
	margin-top: 5px;
	}
	#message p {
	padding: 10px 35px;
	font-size: 15px;
	}
	  .custom-dropdown {
    background-color: #333 !important; /* Dark background with important flag */
    color: #fff !important; /* White text for contrast with important flag */
    border: 1px solid #555 !important; /* Border color with important flag */
  }
  .custom-dropdown option {
    background-color: #333 !important; /* Same dark background for options with important flag */
    color: #fff !important; /* Consistent white text for readability with important flag */
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
					<?php
function checkUsernameAvailability($username) {
    
    try {
        // Escape the username to prevent SQL injection
        $username = mysqli_real_escape_string($con, $username);
        
        // Check in users table
        $query1 = "SELECT COUNT(*) as count FROM users WHERE username = '$username'";
        $result1 = mysqli_query($con, $query1);
        
        if (!$result1) {
            throw new Exception(mysqli_error($con));
        }
        
        $usersCount = mysqli_fetch_assoc($result1)['count'];
        
        // Check in login table
        $query2 = "SELECT COUNT(*) as count FROM login WHERE username = '$username'";
        $result2 = mysqli_query($con, $query2);
        
        if (!$result2) {
            throw new Exception(mysqli_error($con));
        }
        
        $loginCount = mysqli_fetch_assoc($result2)['count'];
        
        // Close database connection
        mysqli_close($con);
        
        // Return response array
        return [
            'available' => ($usersCount === 0 && $loginCount === 0),
            'error' => null
        ];
        
    } catch (Exception $e) {
        mysqli_close($con);
        return [
            'available' => false,
            'error' => 'Database error: ' . $e->getMessage()
        ];
    }
}

// AJAX handler for real-time username checking
if (isset($_POST['check_username'])) {
    $username = trim($_POST['username']);
    
    // Validate username format
    if (empty($username)) {
        echo json_encode(['available' => false, 'error' => 'Username cannot be empty']);
        exit;
    }
    
    // Add any additional validation rules (e.g., length, allowed characters)
    if (strlen($username) < 3) {
        echo json_encode(['available' => false, 'error' => 'Username must be at least 3 characters long']);
        exit;
    }
    
    // You can add more validation rules here
    // For example, checking for valid characters:
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        echo json_encode(['available' => false, 'error' => 'Username can only contain letters, numbers, and underscores']);
        exit;
    }
    
    // Check availability
    $result = checkUsernameAvailability($username);
    echo json_encode($result);
    exit;
}
?>
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
              <label for="full_name">Full Name</label>
              <input type="text" class="form-control" name="full_name" id="full_name" placeholder="" autocomplete="off" required>
            </div>
			


			<div class="form-group">
              <label for="u_name">Username</label>
              <input type="text" class="form-control" name="u_name" id="u_name" placeholder="" autocomplete="off" required>
            </div>
			<div class="form-group">
              <label for="matrix_number">Matrix Number</label>
              <input type="text" class="form-control" name="matrix_number" id="matrix_number" placeholder="" autocomplete="off" required>
			</div>
<div class="form-group">
  <label for="no_ic">IC Number</label>
  <input 
    type="text" 
    class="form-control" 
    name="no_ic" 
    id="no_ic" 
    placeholder="######-##-####" 
    autocomplete="off" 
    maxlength="14"
    required>
</div>
<script>
  const icInput = document.getElementById('no_ic');
  
  icInput.addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
    
    if (value.length > 0) {
      // Format with hyphens
      if (value.length <= 6) {
        value = value;
      } else if (value.length <= 8) {
        value = value.slice(0, 6) + '-' + value.slice(6);
      } else {
        value = value.slice(0, 6) + '-' + value.slice(6, 8) + '-' + value.slice(8, 12);
      }
    }
    
    e.target.value = value;
    
    // Validation
    const isComplete = value.replace(/-/g, '').length === 12;
    e.target.style.borderColor = isComplete ? 'green' : 'red';
  });
</script>




<div class="form-group">
  <label for="course_query">Select your current Major</label>
  <select class="form-control custom-dropdown" name="course_query" id="course_query" required>
    <!-- Options will be populated here -->
  </select>
</div>

<div class="form-group">
    <label for="phone_no">Phone Number</label>
    <input 
        type="text" 
        class="form-control" 
        name="phone_no" 
        id="phone_no" 
        placeholder="###-########" 
        maxlength="12"
        autocomplete="off" 
        required>
</div>
<script>
    const phoneInput = document.getElementById('phone_no');
    
    phoneInput.addEventListener('input', function(e) {
        // Remove all non-digits
        let value = e.target.value.replace(/\D/g, '');
        
        // Format the number
        if (value.length > 0) {
            if (value.length <= 3) {
                value = value;
            } else {
                value = value.slice(0, 3) + '-' + value.slice(3);
            }
        }
        
        // Update input value
        e.target.value = value;
        
        // Validation (optional)
        const isComplete = value.replace(/-/g, '').length === 11;
        e.target.style.borderColor = isComplete ? 'green' : '';
    });

    // Prevent non-numeric input (optional)
    phoneInput.addEventListener('keypress', function(e) {
        if (!/^\d$/.test(e.key) && e.key !== 'Backspace' && e.key !== 'Delete') {
            e.preventDefault();
        }
    });
</script>

            <div class="form-group">
              <label for="pass_key">Password</label>
              <input class="form-control" name="pass_key" id="pass_key" placeholder="Password" pattern="(?=.*\d).{8,}" autocomplete="off" required>
			  <div id="message">
				<h4>Password must contain the following:</h4>
				<p id="number" class="invalid">A <b>number</b></p>
				<p id="length" class="invalid">Minimum <b>8 characters</b></p>
			  </div>
            </div>
            <!-- <legend>Account Details</legend> -->
            <input type="hidden" class="form-control" name="hasApproved" id="textfield" value="No">
<div class="form-group">
  <?php $addressId = mt_rand(1, 1000000000); ?>
  <?php do { $healthId = mt_rand(1, 1000000000); } while ($healthId == $addressId); ?>
  
  <input type="hidden" class="form-control" name="address_id" id="address_id" placeholder="Address ID" value="<?php echo $addressId; ?>" readonly required/>
</div>
<div class="form-group">
  <input type="hidden" class="form-control" name="h_id" id="h_id" placeholder="Health ID" value="<?php echo $healthId; ?>" readonly required/>
</div>

            <div class="form-group">
              <input type="hidden" class="form-control" name="m_id" id="m_id" placeholder="Membership ID" value="<?php echo time(); ?>" readonly required/>
            </div>
            <div class="form-group">
              <button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign Up</button>
            </div>
            <div class="form-group text-center">
              <p>Already have an account? <a href="#" id="show-sign-in">Login</a></p>
            </div>
          </form>
        </div>

<div id="sign-in-section" style="display:none;">
  <h3 class="mb-4">Login</h3>
  <form action="secure_login.php" class="signin-form" method='post' id="bb" onsubmit="rememberMe()">
    <!--<legend>Login Information</legend>-->
    <div class="form-group">
      <label for="user_id_auth">Username</label>
      <input type="text" placeholder="Username" class="form-control" name="user_id_auth" id="user_id_auth" data-rule-minlength="6" data-rule-required="true" required autocomplete="new-username">
    </div>
    <div class="form-group">
      <label for="pwfield">Password</label>
      <input type="password" name="pass_key" id="pwfield" class="form-control" data-rule-required="true" data-rule-minlength="6" placeholder="Password" required autocomplete="new-password">
    </div>
    <div class="form-group">
      <button type="submit" class="form-control btn btn-primary rounded submit px-3">Login</button>
    </div>
    <div class="form-group d-md-flex">
      <!--<div class="form-check w-50">
        <label class="custom-control fill-checkbox">
          <input type="checkbox" class="fill-control-input" id="rememberMe">
          <span class="fill-control-indicator"></span>
          <span class="fill-control-description">Remember Me</span>
        </label>
      </div>-->
      <div class="w-50 text-md-right">
        <a href="forgot_password.php" style="color: #FFFFFF!important">Forgot Password</a>
      </div>
      <div class="w-50 text-md-right">
        <a href="login-admin.php" style="color: #FFFFFF!important">I am an Admin/Coach</a>
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

  function setLocalStorage(name, value) {
    localStorage.setItem(name, value);
  }

  function getLocalStorage(name) {
    return localStorage.getItem(name);
  }

  function rememberMe() {
    var username = document.getElementById('user_id_auth').value;
    var password = document.getElementById('pwfield').value;
    var remember = document.getElementById('rememberMe').checked;
    
    if (remember) {
      setLocalStorage('username', username);
      setLocalStorage('password', password);
    } else {
      localStorage.removeItem('username');
      localStorage.removeItem('password');
    }
  }

  document.addEventListener('DOMContentLoaded', function() {
    var username = getLocalStorage('username');
    var password = getLocalStorage('password');
    
    if (username && password) {
      document.getElementById('user_id_auth').value = username;
      document.getElementById('pwfield').value = password;
      document.getElementById('rememberMe').checked = true;
    }
  });

  // Additional scripts
  var myInput = document.getElementById("pass_key");
  var number = document.getElementById("number");
  var length = document.getElementById("length");

  myInput.onfocus = function() {
    document.getElementById("message").style.display = "block";
  }

  myInput.onblur = function() {
    document.getElementById("message").style.display = "none";
  }

  myInput.onkeyup = function() {
    var numbers = /[0-9]/g;
    if(myInput.value.match(numbers)) {  
      number.classList.remove("invalid");
      number.classList.add("valid");
    } else {
      number.classList.remove("valid");
      number.classList.add("invalid");
    }
    
    if(myInput.value.length >= 8) {
      length.classList.remove("invalid");
      length.classList.add("valid");
    } else {
      length.classList.remove("valid");
      length.classList.add("invalid");
    }
  }

  const UsernameValidator = {
    debounce: function(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },

    checkUsername: function(username, feedbackDiv, input) {
        if (username.length > 0) {
            feedbackDiv.innerHTML = '<small class="text-muted">Checking availability...</small>';
            
            fetch('./loginModal/check_username_availability.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'check_username=1&username=' + encodeURIComponent(username)
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    feedbackDiv.innerHTML = `<small class="text-danger">${data.error}</small>`;
                    input.setCustomValidity(data.error);
                } else if (data.available) {
                    feedbackDiv.innerHTML = '<small class="text-success">Username is available!</small>';
                    input.setCustomValidity('');
                } else {
                    feedbackDiv.innerHTML = '<small class="text-danger">Username is already taken</small>';
                    input.setCustomValidity('Username is already taken');
                }
            })
            .catch(error => {
                feedbackDiv.innerHTML = '<small class="text-danger">Error checking username</small>';
                input.setCustomValidity('Error checking username');
            });
        } else {
            feedbackDiv.innerHTML = '';
            input.setCustomValidity('');
        }
    },

    init: function() {
        const usernameInput = document.getElementById('u_name');
        if (!usernameInput) return;

        const feedbackDiv = document.createElement('div');
        feedbackDiv.id = 'username-feedback';
        usernameInput.parentNode.appendChild(feedbackDiv);

        const debouncedCheck = this.debounce((e) => {
            const username = e.target.value.trim();
            const existingFeedback = document.getElementById('username-feedback');
            if (existingFeedback) {
                existingFeedback.innerHTML = '';
            }
            
            this.checkUsername(username, feedbackDiv, e.target);
        }, 500);

        const newInput = usernameInput.cloneNode(true);
        usernameInput.parentNode.replaceChild(newInput, usernameInput);

        newInput.addEventListener('input', debouncedCheck);
    }
  };

  document.addEventListener('DOMContentLoaded', function() {
    UsernameValidator.init();
  });

  function reinitializeUsernameValidator() {
    UsernameValidator.init();
  }

  document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('course_query');
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '/ICYMK/loginModal/course_suggestions.php', true);
    
    xhr.onload = function() {
      if (this.status == 200) {
        const suggestions = JSON.parse(this.responseText);
        let optionsList = '';
        suggestions.forEach(course => {
          optionsList += `<option value="${course}">${course}</option>`;
        });
        select.innerHTML = optionsList;
      }
    }
    xhr.send();
  });
</script>



</body>
</html>
