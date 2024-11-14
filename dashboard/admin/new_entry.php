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
        
        <div class="a1-container a1-small a1-padding-32" style="margin-top:2px; margin-bottom:2px;">
        <div class="a1-card-8 a1-light-gray" style="width:500px; margin:0 auto;">
		<div class="a1-container a1-dark-gray a1-center">
        	<h6>NEW ENTRY</h6>
        </div>
       <form id="form1" name="form1" method="post" class="a1-container" action="new_submit.php" enctype="multipart/form-data">
         <table width="100%" border="0" align="center">
         <tr>
           <td height="35"><table width="100%" border="0" align="center">
           	 <tr>
           	   <td height="35">Membership ID:</td>
           	   <td height="35"><input type="text" id="boxx" name="m_id" value="<?php echo time(); ?>" readonly required/></td>
         	   </tr>
			   
			<tr>
			 <td height="35">Profile Picture: </td>
				<td height="35">
				<input type="file" name="image" accept="image/*">
			</tr>

			   <tr>
               <td height="35">Name:</td>
               <td height="35"><input name="u_name" id="boxx"  required/></td>
             </tr>
			 <tr>
               <td height="35">User Password:</td>
               <td height="35"><input name="pass_key" id="boxx"  required/></td>
             </tr>
             <tr>
               <td height="35">Street Name:</td>
               <td height="35"><input  name="street_name" id="boxx"></td>
             </tr>
             <tr>
               <td height="35">City:</td>
               <td height="35"><input type="text" name="city" id="boxx"></td>
             </tr>
             <tr>
               <td height="35">Zipcode:</td>
               <td height="35"><input type="number" name="zipcode" id="boxx" maxlength="5"></td>
             </tr>
            <tr>
               <td height="35">State:</td>
               <td height="35"><input type="text" name="state" id="boxx" size="30"></td>
             </tr>
            <tr>
               <td height="35">Gender:</td>
               <td height="35"><select name="gender" id="boxx">

					<option value="">--Please Select--</option>
					<option value="Male">Male</option>
					<option value="Female">Female</option>
				</select></td>
             </tr>
            <tr>
               <td height="35">Date Of Birth:</td>
               <td height="35"><input type="date" name="dob" id="boxx"size="30"></td>
             </tr>
			 <tr>
               <td height="35">Phone No:</td>
               <td height="35"><input type="number" name="mobile" id="boxx" maxlength="10" size="30"></td>
             </tr>
			  <tr>
               <td height="35">Email ID:</td>
               <td height="35"><input type="email" name="email" id="boxx" required/ size="30"></td>
             </tr>
			 <tr>
               <td height="35">Joining Date:</td>
               <td height="35"><input type="date" name="jdate" id="boxx" size="30"></td>
             </tr>
             <tr>
			<!-- <td height="35">YOUR HEALTH ID:</td> -->
           	   <td height="0"><input type="hidden" id="boxx" name="h_id" value="<?php $randomNumber = mt_rand(1, 1000000000); echo $randomNumber;?>" required/></td>
           	   </tr>
           	   <tr>
           	   <!--<td height="35">YOUR ADDRESS ID:</td>-->
           	   <td height="0"><input type="hidden" id="boxx" name="address_id" value="<?php $randomNumber = mt_rand(1, 1000000000); echo $randomNumber;?>" required/></td>
           	   </tr> 
			</tr>
             <tr>
               <td height="35">Choose Plan:</td>
               <td height="35"><select name="plan" id="boxx" required onchange="myplandetail(this.value)">
					<option value="">--Please Select--</option>
					<?php
						$query="select * from plan where active='yes'";
						$result=mysqli_query($con,$query);
						if(mysqli_affected_rows($con)!=0){
							while($row=mysqli_fetch_row($result)){
								echo "<option value=".$row[0].">".$row[2]."</option>";
							}
						}

					?>
					
				</select></td>
             </tr>
			
	    <tbody id="plandetls">
             
            </tbody>

             <tr>
             <tr>
               <td height="35">&nbsp;</td>
               <td height="35"><input class="a1-btn a1-blue" type="submit" name="submit" id="submit" value="Register" >
                 <input class="a1-btn a1-blue" type="reset" name="reset" id="reset" value="Reset">
				 <input class="a1-btn a1-blue" type="button" value="Return" onclick="window.location.href='view_mem.php'"></td>
             </tr>
           </table></td>
         </tr>
         </table>
       </form>
    </div>
    </div>   
        
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

