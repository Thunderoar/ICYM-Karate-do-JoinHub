<?php
require '../../include/db_conn.php';
page_protect();

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <title>ICYM Karate-Do | Detail Timetable</title>
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
	<style>
    	.page-container .sidebar-menu #main-menu li#routinehassubopen > a {
    	background-color: #2b303a;
    	color: #ffffff;
		}

    </style>
	<script>
	function myFunction()
	{
		var prt=document.getElementById("print");
		var WinPrint=window.open('','','left=0,top=0,width=800,height=900,tollbar=0,scrollbars=0,status=0');
		WinPrint.document.write(prt.innerHTML);
		WinPrint.document.close();
		WinPrint.focus();
		WinPrint.print();
		WinPrint.close();
		setPageHeight("297mm");
		setPageWidth("210mm");
		setHtmlZoom(100);
		//window.location.replace("index.php?query=");
	}
	</script>

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
				<h2>Routine Detail</h2>
				<hr/>

				<?php
$id = $_GET['id'];


// Prepare the SQL query
$sql = "SELECT * FROM sports_timetable t WHERE t.tid = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id); // "i" denotes integer type

// Execute the query
$stmt->execute();
$res = $stmt->get_result();

if ($res) {
    $row = $res->fetch_array(MYSQLI_ASSOC);
    // Continue with the rest of your code
} else {
    // Handle error
    echo "Error: " . $stmt->error;
}
?>

		<div id=print>
		<table width="619" height="673" border="1" align="center">
  <tr>
    <td height="87" colspan="2">Timetable Name:<?php echo $row['tname'] ?> &ensp;&ensp;&ensp;&ensp;&ensp; &ensp;&ensp;&ensp;&ensp;&ensp; &ensp;&ensp;&ensp;&ensp;&ensp; &ensp;&ensp;&ensp;&ensp;&ensp;  &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp; &ensp;&ensp;&ensp;&ensp;&ensp;<span align="right"> <!-- <img src="" alt="." width="121" height="114"  alt=""/>--></span></td>
    </tr>
  <tr>
    <td width="186" height="103">Day 1:</td>
    <td width="417"><?php echo $row['day1'] ?></td>
  </tr>
  <tr>
    <td height="96">Day 2:</td>
    <td><?php echo $row['day2'] ?></td>
  </tr>
  <tr>
    <td height="87">Day 3:</td>
    <td><?php echo $row['day3'] ?></td>
  </tr>
  <tr>
    <td height="92">Day 4:</td>
    <td><?php echo $row['day4'] ?></td>
  </tr>
  <tr>
    <td height="84">Day 5:</td>
    <td><?php echo $row['day5'] ?></td>
  </tr>
  <tr>
    <td height="75">Day 6:</td>
    <td><?php echo $row['day6'] ?></td>
  </tr>
        </table></div>

			<!-- <input type="button" class="a1-btn a1-blue" value="PRINT TIMETABLE" onclick="myFunction()"> -->
		
		
		
		
		
		
		

			

    	</div>

    </body>
	<?php include('footer.php'); ?>
</html>


										
