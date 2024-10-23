
<?php
require '../../include/db_conn.php';
page_protect();
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <title>ICYM Karate-Do Club | Timetable</title>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../../css/style.css"  id="style-resource-5">
    <script type="text/javascript" src="../../js/Script.js"></script>
    <link rel="stylesheet" href="../../css/dashMain.css">
    <link rel="stylesheet" type="text/css" href="../../css/entypo.css">
	<link href="a1style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="../../css/bootstrap.min.css">
	<script src="../../js/jquery.min.js"></script>
	<script src="../../js/bootstrap.min.js"></script>
	
	<link rel="stylesheet" href="../../css/dashboard/sidebar.css">
    <style>
      .page-container .sidebar-menu #main-menu li#routinehassubopen > a {
      background-color: #2b303a;
      color: #ffffff;
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
					<div class="sidebar-collapse" onclick="collapseSidebar()">
				<a href="#" class="sidebar-collapse-icon with-animation"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
					<i class="entypo-menu"></i>
				</a>
			</div>
							
			
		
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

		<h3>Add to Timetable</h3>

		<hr />

		
		
		 <div class="a1-container a1-small a1-padding-32" style="margin-top:2px; margin-bottom:2px;">
        <div class="a1-card-8 a1-light-gray" style="width:500px; margin:0 auto;">
		<div class="a1-container a1-dark-gray a1-center">
        	<h6>Add new Activity to Timetable</h6>
        </div>
       <form id="form1" name="form1" method="post" class="a1-container" action="saveroutine.php">
         <table width="100%" border="0" align="center">
         <tr>
           <td height="35"><table width="100%" border="0" align="center">
           	 <tr>
           	   <td height="35">Timetable Name:</td>
           	   <td height="35"><input name="rname"  size="30" required/></td>
         	   </tr>
<tr>
    <td height="35">Plan:</td>
    <td height="35">
        <select name="pidd" required>
            <option value="" disabled selected>Select a plan</option> <!-- Default option -->
            <?php
            // Fetch plans from the database
            $query = "SELECT planid, planName FROM plan WHERE active='yes'"; // Assuming you only want active plans
            $result = mysqli_query($con, $query);
            
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['planid'] . '">' . $row['planName'] . '</option>';
                }
            } else {
                echo '<option value="" disabled>Error fetching plans</option>'; // Handle errors
            }
            ?>
        </select>
    </td>
</tr>
			   
			   <tr>
               <td height="35">DAY 1:</td>
               <td height="35"><label for="textarea"></label>
                 <textarea name="day1" id="textarea" style="margin: 0px; width: 236px; height: 42px; resize:none;"></textarea></td>
             </tr>
             <tr>
               <td height="35">DAY 2:</td>
               <td height="35"><label for="textarea"></label>
                 <textarea name="day2" id="textarea" style="margin: 0px; width: 236px; height: 42px;resize:none;"></textarea></td></td>
             </tr>
             <tr>
               <td height="35">DAY 3:</td>
               <td height="35"><label for="textarea"></label>
                 <textarea name="day3" id="textarea" style="margin: 0px; width: 236px; height: 42px;resize:none;"></textarea></td></td>
             </tr>
             <tr>
               <td height="35">DAY 4:</td>
               <td height="35"><label for="textarea"></label>
                 <textarea name="day4" id="textarea" style="margin: 0px; width: 236px; height: 42px;resize:none;"></textarea></td></td>
             </tr>
            <tr>
               <td height="35">DAY 5:</td>
               <td height="35"><label for="textarea"></label>
                 <textarea name="day5" id="textarea" style="margin: 0px; width: 236px; height: 42px;resize:none;"></textarea><td></td>
             </tr>
             <tr>
               <td height="35">DAY 6:</td>
               <td height="35"><label for="textarea"></label>
                 <textarea name="day6" id="textarea" style="margin: 0px; width: 236px; height: 42px;resize:none;"></textarea></td></td>
             </tr>
<tr>
    <td height="35">Choose Staff:</td>
    <td height="35">
        <select name="staff" id="boxx" required onchange="mystaffdetail(this.value)">
            <option value="">--Please Select--</option>
            <?php
                // Query to select all staff
                $query = "SELECT * FROM staff";
                $result = mysqli_query($con, $query);
                
                // Check if there are any rows returned
                if (mysqli_num_rows($result) > 0) {
                    // Fetch each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Construct the option value, including staff name and other details
                        echo "<option value='{$row['staffid']}' 
                              data-username='{$row['username']}' 
                              data-role='{$row['role']}'>"
                              . htmlspecialchars($row['name']) . "</option>";
                    }
                }
            ?>
        </select>
    </td>
</tr>			 
             <td height="0"><input type="hidden" name="hasApproved"  size="0" value="yes" required/></td>           
             <tr>
             <tr>
               <td height="35">&nbsp;</td>
               <td height="35"><input class="a1-btn a1-blue" type="submit" name="submit" id="submit" value="Add new Timetable" >
                 <input class="a1-btn a1-blue" type="reset" name="reset" id="reset" value="Reset"></td>
             </tr>
           </table></td>
         </tr>
         </table>
       </form>
    </div>
    </div>   
		
		
		
		
		


<?php include('footer.php'); ?>
    	</div>

<script>
function mystaffdetail(staffId) {
    var selectBox = document.getElementById("boxx");
    var selectedOption = selectBox.options[selectBox.selectedIndex];

    // Check if a valid staff is selected
    if (staffId) {
        var username = selectedOption.getAttribute('data-username');
        var role = selectedOption.getAttribute('data-role');

        // Example of how to display the details
        console.log("Staff ID: " + staffId);
        console.log("Username: " + username);
        console.log("Role: " + role);
        
        // You can add more code here to display the information on the page as needed
    }
}
</script>
    </body>
</html>


				
