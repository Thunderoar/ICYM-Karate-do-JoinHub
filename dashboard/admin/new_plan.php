<?php
require '../../include/db_conn.php';
page_protect();
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <title>ICYM Karate-Do  | New Plan</title>
  
	<link rel="stylesheet" href="../../css/style.css"  id="style-resource-5">
    <script type="text/javascript" src="../../js/Script.js"></script>
    <link rel="stylesheet" href="../../css/dashMain.css">
    <link rel="stylesheet" type="text/css" href="../../css/entypo.css">
	<link href="a1style.css" rel="stylesheet" type="text/css">
	
	<link rel="stylesheet" href="../../css/dashboard/sidebar.css">
	<style>
    	.page-container .sidebar-menu #main-menu li#planhassubopen > a {
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

		<h3>Create Plan</h3>

		<hr />
		
<div class="a1-container a1-small a1-padding-32" style="margin-top:2px; margin-bottom:2px;">
    <div class="a1-card-8 a1-light-gray" style="width:600px; margin:0 auto;">
        <div class="a1-container a1-dark-gray a1-center">
            <h6>NEW PLAN DETAILS</h6>
        </div>
        <form id="form1" name="form1" method="post" class="a1-container" action="submit_plan_new.php" enctype="multipart/form-data">
            <table width="100%" border="0" align="center">
                <tr>
                    <td height="35">
                        <table width="100%" border="0" align="center">
                            <tr>
                                <td height="35">Type of Plan:</td>
                                <td height="35">
                                    <select name="plantype" id="plantype" required onchange="updateFeeLabel()">
                                        <option value="">--Please Select--</option>
                                        <option value="Core">Core</option>
                                        <option value="Event">Event</option>
                                        <option value="Tournament">Tournament</option>
                                        <option value="Collaboration">Collaboration</option>
                                    </select>
                                </td>
                            </tr>  

                            <tr>
                                <td height="35">Event Image:</td>
                                <td height="35">
                                    <input type="file" name="image" accept="image/*">
                                </td>
                            </tr>

           	 <tr>
           	   <td height="35">PLAN ID:</td>
           	   <td height="35"><?php
							function getRandomWord($len = 6)
							{
							    $word = array_merge(range('A', 'Z'));
							    shuffle($word);
							    return substr(implode($word), 0, $len);
							}

						?>
				<input type="text" name="planid" id="planID" readonly value="<?php echo getRandomWord(); ?>"></td>
         	   </tr>

                            <tr>
                                <td height="35">Plan Name:</td>
                                <td height="35">
                                    <input name="planname" id="planName" type="text" placeholder="Enter plan name" size="40">
                                </td>
                            </tr>

                            <tr>
                                <td height="35">Plan Description:</td>
                                <td height="35">
                                    <input type="text" name="desc" id="planDesc" placeholder="Enter plan description" size="40">
                                </td>
                            </tr>

                            <tr>
                                <td height="35">Start Date:</td>
                                <td height="35">
                                    <input type="date" name="startDate"  id="startDate" onchange="calculateDuration()">
                                </td>
                            </tr>

                            <tr>
                                <td height="35">End Date:</td>
                                <td height="35">
                                    <input type="date" name="endDate"  id="endDate" onchange="calculateDuration()">
                                </td>
                            </tr>

                            <tr>
                                <td height="35">Duration (Days):</td>
                                <td height="35">
                                    <input type="number" name="duration"  id="duration" readonly>
                                </td>
                            </tr>

                            <tr>
                                <td height="35" id="feeLabel">Plan Fee:</td>
                                <td height="35">
                                    <input type="text" name="amount" id="planAmnt" placeholder="Enter plan amount" size="40">
                                </td>
                            </tr>     

                            <tr>
                                <td height="35">&nbsp;</td>
                                <td height="35">
                                    <input class="a1-btn a1-blue" type="submit" name="submit" id="submit" value="CREATE PLAN">
                                    <input class="a1-btn a1-blue" type="reset" name="reset" id="reset" value="Reset">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
		
		

			<?php include('footer.php'); ?>
    	</div>

    </body>
	<script>
	function updateFeeLabel() {
        const selectedPlanType = document.getElementById('plantype').value;
        const feeLabel = document.getElementById('feeLabel');

        // Update the label text based on selected plan type
        if (selectedPlanType) {
            feeLabel.innerText = selectedPlanType + " Fee:"; // Update the label to show the selected plan type
        } else {
            feeLabel.innerText = "Plan Fee:"; // Default label if no plan is selected
        }
    }
	
    function calculateDuration() {
        const startDateInput = document.getElementById('startDate').value;
        const endDateInput = document.getElementById('endDate').value;

        if (startDateInput && endDateInput) {
            const startDate = new Date(startDateInput);
            const endDate = new Date(endDateInput);
            const duration = (endDate - startDate) / (1000 * 60 * 60 * 24); // Convert milliseconds to days

            document.getElementById('duration').value = duration >= 0 ? duration : 0; // Ensure duration is not negative
        } else {
            document.getElementById('duration').value = ''; // Clear duration if dates are not both selected
        }
    }
</script>
</html>


