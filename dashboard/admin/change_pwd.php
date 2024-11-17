<?php
require '../../include/db_conn.php';
page_protect();
?>


<!DOCTYPE html>
<html lang="en">
<head>

    <title>SPORTS CLUB | Reset</title>
     <link rel="stylesheet" href="../../css/style.css"  id="style-resource-5">
    <script type="text/javascript" src="../../js/Script.js"></script>
    <link rel="stylesheet" href="../../css/dashMain.css">
    <link rel="stylesheet" type="text/css" href="../../css/entypo.css">
	<link href="a1style.css" rel="stylesheet" type="text/css">
	
	<link rel="stylesheet" href="../../css/dashboard/sidebar.css"> 
	<style>
    	.page-container .sidebar-menu #main-menu li#adminprofile > a {
    	background-color: #2b303a;
    	color: #ffffff;
		}
         </style>

<style>#boxx
	{
		width:220px;
	}</style>

</head>
    <body class="page-body  page-fade" onload="collapseSidebar()">

    	<div class="page-container sidebar-collapsed" id="navbarcollapse">	
	
		<div class="sidebar-menu">
	
			<header class="logo-env">
			
			<!-- logo -->
			<?php
			 require('../../element/loggedin-logo.html');
			?>
			
					<!-- logo collapse icon 
					<div class="sidebar-collapse" onclick="collapseSidebar()">
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
						
							<li>
								<a href="logout.php">
									Log Out <i class="entypo-logout right"></i>
								</a>
							</li>
						</ul>
						
					</div>
					
				</div>

		<h3>Change Password</h3>

		<hr />

		
		
		
		
		
<div class="a1-container a1-small a1-padding-32" style="margin-top:2px; margin-bottom:2px;">
    <div class="a1-card-8 a1-light-gray" style="width:500px; margin:0 auto;">
        <div class="a1-container a1-dark-gray a1-center">
            <h6>CHANGE PASSWORD</h6>
        </div>
        <form id="form1" name="form1" action="change_s_pwd.php" method="POST" class="a1-container">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="entypo-user"></i>
                    </div>
                    <input type="text" class="form-control" name="login_id" readonly value="<?php echo $_SESSION['user_data']; ?>" placeholder="Your Login ID" required />
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="entypo-key"></i>
                    </div>
                    <input type="text" name="login_key" class="form-control" placeholder="Your secret key" required minlength="6">
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="entypo-key"></i>
                    </div>
                    <input type="password" name="pwfield" id="pwfield" class="form-control" placeholder="Your new password" required minlength="6">
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="entypo-key"></i>
                    </div>
                    <input type="password" name="confirmfield" id="confirmfield" class="form-control" placeholder="Confirm your new password" required minlength="6" data-rule-equalto="#pwfield">
                </div>
            </div>

            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-primary">
                    Change Password
                    <i class="entypo-login"></i>
                </button>
                <a href="more-userprofile.php">
                    <button type="button" class="btn btn-primary">Cancel</button>
                </a>
            </div>
        </form>
    </div>
</div>

		
		
		
		
		
		
		
			<?php include('footer.php'); ?>
    	</div>

    </body>
</html>


