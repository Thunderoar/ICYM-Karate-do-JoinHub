<?php
require '../../include/db_conn.php';
page_protect();
if (isset($_POST['userID']) && isset($_POST['planID'])) {
    $uid  = $_POST['userID'];
    $planid=$_POST['planID'];
    $query1 = "select * from users WHERE userid='$uid'";
    
    $result1 = mysqli_query($con, $query1);
    
    if (mysqli_affected_rows($con) == 1) {
        while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
            
            $name = $row1['username'];
            $query2="select * from plan where planid='$planid'";

            $result2=mysqli_query($con,$query2);
            if($result2){
               $planValue=mysqli_fetch_array($result2,MYSQLI_ASSOC);
               $planName=$planValue['planName'];
			   $amount=$planValue['amount'];
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <title>ICYM Karate-Do  | Make Payment</title>
     <link rel="stylesheet" href="../../css/style.css"  id="style-resource-5">
    <script type="text/javascript" src="../../js/Script.js"></script>
    <link rel="stylesheet" href="../../css/dashMain.css">
    <link rel="stylesheet" type="text/css" href="../../css/entypo.css">
    <link href="a1style.css" type="text/css" rel="stylesheet">
	
	<link rel="stylesheet" href="../../css/dashboard/sidebar.css">
    <style>
    	.page-container .sidebar-menu #main-menu li#paymnt > a {
    	background-color: #2b303a;
    	color: #ffffff;
		}
	#boxx
	{
		width:220px;
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
						
							<li>
								<a href="logout.php">
									Log Out <i class="entypo-logout right"></i>
								</a>
							</li>
						</ul>
						
					</div>
					
				</div>

		<h3>ICYM Karate-Do Club</h3>

		<hr />

		
		
		
		
		
<div class="a1-container a1-small a1-padding-32" style="margin-top:2px; margin-bottom:2px;">
    <div class="a1-card-8 a1-light-gray" style="width:500px; margin:0 auto;">
        <div class="a1-container a1-dark-gray a1-center">
            <h6>MAKE PAYMENT</h6>
        </div>
        <!-- Add enctype attribute for file upload -->
        <form id="form1" name="form1" method="post" class="a1-container" action="submit_payments.php" enctype="multipart/form-data">
            <table width="100%" border="0" align="center">
                <tr>
                    <td height="35">
                        <table width="100%" border="0" align="center">
                            <tr>
                                <td height="35">MEMBERSHIP ID:</td>
                                <td height="35"><input type="text" name="m_id" id="boxx" value="<?php echo $uid; ?>" readonly/></td>
                            </tr>
                            <tr>
                                <td height="35">NAME:</td>
                                <td height="35"><input type="text" name="u_name" id="boxx" value="<?php echo $name; ?>" placeholder="Member Name" maxlength="30" readonly/></td>
                            </tr>
                            <tr>
                                <td height="35">CURRENT PLAN:</td>
                                <td height="35"><input type="text" name="curPlan" id="boxx" value="<?php echo $planName; ?>" readonly></td>
                                <td height="0"><input type="hidden" name="plan" id="boxx" value="<?php echo $planid; ?>" readonly></td>
                            </tr>
							               <td height="35">FEE:</td>
<td height="35">
    <input type="text" name="curFee" id="boxx" class="bold-input" value="RM <?php echo $amount; ?>" readonly>
</td>
										<tr>
               <td height="35"><b>Pay to below account:<b></td>
<label></label>

             </tr>		
			<tr>
               <td height="35"><b>Bank Islam:</b> 01929301928391</td>
<label></label>

             </tr>	
			<tr>
               <td height="35"></td>
<label></label>

             </tr>	
                            <tr>
                                <!-- File input for payment receipt with preview -->
                                <td height="35">Upload Receipt:</td>
                                <td height="35">
                                    <input type="file" name="receiptIMG" id="receiptIMG" accept="image/*" onchange="previewImage();"/>
                                </td>
                            </tr>
                            <!-- Image preview -->
                            <tr>
                                <td colspan="2" style="text-align: center;">
                                    <img id="receiptPreview" src="#" alt="Receipt Preview" style="display: none; max-width: 100%; height: auto; border: 1px solid #ccc; margin-top: 10px;">
                                </td>
                            </tr>
                        </table>
											<tr>
    <td height="35" style="display: flex; align-items: center; justify-content: flex-start;">
        <!-- Reverted to previous button styles -->
        <input class="a1-btn a1-blue" type="submit" name="submit" id="submit" value="Add Payment" style="margin-right: 10px;">
        <input class="a1-btn a1-blue" type="reset" name="reset" id="reset" value="Reset" style="margin-right: 10px;" onclick="resetPreview();">
        <!-- New 'Return' button -->
        <a href="payments.php" class="a1-btn a1-blue" style="text-decoration: none;">Return</a>
    </td>
</tr>
                    </td>

                </tr>


            </table>
        </form>
    </div>
</div>
 
		
		
		
		

		<?php include('footer.php'); ?>

		</div>


    </body>
</html>


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
			
// JavaScript function to preview the uploaded image
function previewImage() {
    var preview = document.getElementById('receiptPreview');
    var file = document.getElementById('receiptIMG').files[0];
    var reader = new FileReader();

    reader.onloadend = function () {
        preview.src = reader.result;
        preview.style.display = 'block'; // Show the image preview
    };

    if (file) {
        reader.readAsDataURL(file); // Convert file to base64 string
    } else {
        preview.src = "";
        preview.style.display = 'none'; // Hide preview if no file
    }
}

// Reset image preview when the form is reset
function resetPreview() {
    var preview = document.getElementById('receiptPreview');
    preview.src = "";
    preview.style.display = 'none';
}
        </script>

<?php
} else {
    
}
?>
