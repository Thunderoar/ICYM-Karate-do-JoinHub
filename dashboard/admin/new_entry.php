<?php
require '../../include/db_conn.php';
page_protect();
?>


<!DOCTYPE html>
<html lang="en">
<head>

    <title>ICYM Karate-Do | New User</title>
    <link rel="stylesheet" href="../../css/style.css"  id="style-resource-5">
    <script type="text/javascript" src="../../js/Script.js"></script>
    <link rel="stylesheet" href="../../css/dashMain.css">
    <link rel="stylesheet" type="text/css" href="../../css/entypo.css">
    <link href="a1style.css" type="text/css" rel="stylesheet">
    <script src="../../js/moment.min.js"></script>
	<script src="../../js/jquery-3.4.1.min.js"></script>
	
	<link rel="stylesheet" href="../../css/dashboard/sidebar.css">
    <style>
    	.page-container .sidebar-menu #main-menu li#regis > a {
    	background-color: #2b303a;
    	color: #ffffff;
		}
       #boxx
	{
		width:220px;
	}
	 #space
{
line-height:0.5cm;
}
.home-button {
    position: fixed; /* Fixed positioning */
    bottom: 20px; /* Distance from the bottom of the viewport */
    right: 20px; /* Distance from the right of the viewport */
    background-color: #007bff; /* Bootstrap primary color */
    color: white; /* Text color */
    padding: 20px 25px; /* Padding around the button */
    border-radius: 5px; /* Rounded corners */
    text-decoration: none; /* No underline */
    font-size: 16px; /* Font size */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Shadow effect */
    transition: background-color 0.3s; /* Transition effect */
}

.home-button:hover {
    background-color: #0056b3; /* Darker blue on hover */
}
/* Container styling */
.a1-container {
  max-width: 600px;
  margin: auto;
  font-family: Arial, sans-serif;
}

.a1-card-8 {
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
  border-radius: 10px;
}

.a1-dark-gray {
  background-color: #333;
  color: #fff;
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
  padding: 15px;
}

/* Form Styling */
form {
  padding: 20px;
}

form label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
  color: #444;
}

form input[type="text"],
form input[type="date"],
form input[type="number"],
form input[type="email"],
form input[type="password"],
form input[type="file"],
form select {
  width: 100%;
  padding: 8px 12px;
  margin-bottom: 15px;
  border: 1px solid #ddd;
  border-radius: 5px;
  transition: border 0.3s;
  box-sizing: border-box;
}

form input[type="text"]:focus,
form input[type="date"]:focus,
form input[type="number"]:focus,
form input[type="email"]:focus,
form input[type="password"]:focus,
form input[type="file"]:focus,
form select:focus {
  border-color: #007bff;
  box-shadow: 0 0 5px rgba(0, 123, 255, 0.2);
  outline: none;
}

/* Fieldset Styling */
fieldset {
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 15px;
  margin-bottom: 20px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

legend {
  font-size: 1.2em;
  color: #333;
  padding: 0 10px;
  font-weight: bold;
}

/* Button Styling */
.a1-btn {
  padding: 10px 20px;
  font-size: 14px;
  font-weight: bold;
  color: #fff;
  background-color: #007bff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s, transform 0.3s;
}

.a1-btn:hover {
  background-color: #0056b3;
  transform: translateY(-2px);
}

.a1-btn:active {
  transform: translateY(1px);
}

.a1-blue {
  background-color: #007bff;
}

.a1-btn + .a1-btn {
  margin-left: 10px;
}

/* Table Styling */
table {
  width: 100%;
  border-collapse: collapse;
}

table tr td {
  padding: 10px;
}

table tr td label {
  margin-bottom: 5px;
  color: #444;
}

	</style>

</head>
      <body class="page-body  page-fade" onload="collapseSidebar()">

    	<div class="page-container sidebar-collapsed" id="navbarcollapse">	
	
		<div class="sidebar-menu">
	
			<header class="logo-env">
			
			<!-- logo -->
			<?php
			 require('../../element/loggedin-logo.html');
			?>
			
					<!-- logo collapse icon -->
					<!-- <div class="sidebar-collapse" onclick="collapseSidebar()">
				<a href="#" class="sidebar-collapse-icon with-animation"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition 
					<i class="entypo-menu"></i>
				</a>
			</div>-->
							
			
		
			</header>
    		<?php include('nav.php'); ?>
    	</div>

    		<div class="main-content">
		
				<div class="row">
					
					<!-- Profile Info and Notifications -->
					<div class="col-md-6 col-sm-8 clearfix">	
							
					</div>
					
					
					<!-- Raw Links -->
					<div class="col-md-6 col-sm-4 clearfix hidden-xs">
						
						<ul class="list-inline links-list pull-right">

						<?php
						require('../../element/loggedin-welcome.html');
					?>
							</li>
						
							<li>
								<a href="logout.php">
									Log Out <i class="entypo-logout right"></i>
								</a>
							</li>
						</ul>
						
					</div>
					
				</div>

		
        	<h3>New Registration</h3>

		<hr />
        

<div style="margin: 20px auto; padding: 20px; max-width: 100%;">


  <form id="form1" name="form1" method="post" action="new_submit.php" enctype="multipart/form-data" style="background-color: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
    
<!-- Profile Picture Section -->
<div style="display: flex; justify-content: flex-end;"> <!-- Added Flexbox container -->
  <fieldset style="margin-bottom: 20px; padding: 20px; border-radius: 8px; border: 1px solid #ccc;">
    <legend style="font-size: 20px; color: #333; font-weight: bold;">Profile Picture</legend>
    <div>
      <input type="file" name="image" accept="image/*" style="margin-bottom: 10px;" onchange="previewImage(event)">
      <div id="imagePreview" style="margin-top: 10px;">
        <img id="chosenImage" src="" alt="Profile Preview" style="display: none; max-width: 150px; border-radius: 8px;"/>
      </div>
    </div>
  </fieldset>
</div>

<!-- Personal Information Section -->
<fieldset style="margin-bottom: 20px; padding: 20px; border-radius: 8px; border: 1px solid #ccc;">
  <legend style="font-size: 20px; color: #333; font-weight: bold;">Personal Information</legend>
  <div>
    <div style="margin-bottom: 10px;">
      <label>Membership ID:</label>
      <input type="text" name="m_id" value="<?php echo time(); ?>" readonly required style="width: 100%;" />
    </div>
    <div style="margin-bottom: 10px;">
      <label>Full Name:</label>
      <input type="text" name="fullName" required style="width: 100%;" />
    </div>
    <div style="margin-bottom: 10px;">
      <label>Username:</label>
      <input type="text" name="u_name" required style="width: 100%;" />
    </div>
    <div style="margin-bottom: 10px;">
      <label>Gender:</label>
      <select name="gender" required style="width: 100%;">
        <option value="">--Please Select--</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
      </select>
    </div>
    <div style="margin-bottom: 10px;">
      <label>Date of Birth:</label>
      <input type="date" name="dob" required style="width: 100%;">
    </div>
    <div style="margin-bottom: 10px;">
      <label>Phone No:</label>
      <input type="number" name="mobile" maxlength="10" required style="width: 100%;">
    </div>
    <div style="margin-bottom: 10px;">
      <label>Email ID:</label>
      <input type="email" name="email" required style="width: 100%;">
    </div>
	    <div style="margin-bottom: 10px;">
      <label>Matrix No.:</label>
      <input type="text" name="matrix_number" required style="width: 100%;" />
    </div>
    <div style="margin-bottom: 10px;">
      <label>Current Member Education Course:</label>
      <input type="text" name="selectedCourse" required style="width: 100%;" />
    </div>
    <div style="margin-bottom: 10px;">
      <label>User Password:</label>
      <input type="password" name="pass_key" required style="width: 100%;">
    </div>
  </div>
</fieldset>

<!-- Address Section -->
<fieldset style="margin-bottom: 20px; padding: 20px; border-radius: 8px; border: 1px solid #ccc;">
  <legend style="font-size: 20px; color: #333; font-weight: bold;">Address</legend>
  <div>
    <div style="margin-bottom: 10px;">
      <label>Street Name:</label>
      <input type="text" name="street_name" style="width: 100%;">
    </div>
    <div style="margin-bottom: 10px;">
      <label>City:</label>
      <input type="text" name="city" style="width: 100%;">
    </div>
    <div style="margin-bottom: 10px;">
      <label>Zipcode:</label>
      <input type="number" name="zipcode" maxlength="5" style="width: 100%;">
    </div>
    <div style="margin-bottom: 10px;">
      <label>State:</label>
      <input type="text" name="state" style="width: 100%;">
    </div>
  </div>
</fieldset>

<!-- Membership Details Section -->
<fieldset style="margin-bottom: 20px; padding: 20px; border-radius: 8px; border: 1px solid #ccc;">
  <legend style="font-size: 20px; color: #333; font-weight: bold;">Membership Details</legend>
  <div>
    <div style="margin-bottom: 10px;">
      <label>Choose Plan:</label>
      <select name="plan" required style="width: 100%;" onchange="myplandetail(this.value)">
        <option value="">--Please Select--</option>
        <?php
          $query = "select * from plan where active='yes'";
          $result = mysqli_query($con, $query);
          if (mysqli_affected_rows($con) != 0) {
            while ($row = mysqli_fetch_row($result)) {
              echo "<option value=" . $row[0] . ">" . $row[2] . "</option>";
            }
          }
        ?>
      </select>
    </div>
  </div>
  <div id="plandetls" style="margin-top: 10px;"></div>
</fieldset>


    <!-- Form Actions -->
    <div style="text-align: center; margin-top: 20px;">
      <button type="submit" class="a1-btn a1-blue">Register</button>
      <button type="reset" class="a1-btn a1-blue">Reset</button>
      <button type="button" class="a1-btn a1-blue" onclick="window.location.href='view_mem.php'">Return</button>
    </div>
  </form>
</div>

<script>
  function previewImage(event) {
    const imagePreview = document.getElementById('imagePreview');
    const chosenImage = document.getElementById('chosenImage');
    
    chosenImage.src = URL.createObjectURL(event.target.files[0]);
    chosenImage.style.display = 'block';
    imagePreview.style.display = 'block';
  }
</script>






        
        <script>
        	function myplandetail(str){

        		if(str==""){
        			document.getElementById("plandetls").innerHTML = "";
        			return;
        		}else{
        			if (window.XMLHttpRequest) {
           		 // code for IE7+, Firefox, Chrome, Opera, Safari
           			 xmlhttp = new XMLHttpRequest();
       				 }
       			 	xmlhttp.onreadystatechange = function() {
            		if (this.readyState == 4 && this.status == 200) {
               		 document.getElementById("plandetls").innerHTML=this.responseText;
                
            			}
        			};
        			
       				 xmlhttp.open("GET","plandetail.php?q="+str,true);
       				 xmlhttp.send();	
        		}
        		
        	}
        </script>
        
        
			<?php include('footer.php'); ?>
						<a class="btn-sm px-4 py-3 d-flex home-button" style="background-color:#2a2e32" href="view_mem.php">Return Back</a>	
    	</div>

    </body>
</html>

