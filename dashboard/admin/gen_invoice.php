<?php
require '../../include/db_conn.php';
page_protect();
$etid=$_GET['etid'];
$pid=$_GET['pid'];
$uid=$_GET['id'];



					$sql = "SELECT * FROM users u
					INNER JOIN enrolls_to e ON u.userid = e.userid
					INNER JOIN plan p ON p.planid = e.planid
					WHERE u.userid = '".$uid."'
					AND e.et_id = '".$etid."'";
					$res=mysqli_query($con, $sql);
					 if($res){
						      	$row=mysqli_fetch_array($res,MYSQLI_ASSOC);
				
						      }
				
					

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ICYM Karate-Do</title>
<style>
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
        <script>function myFunction()
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

<body>
<br><input type="button" class="a1-btn a1-green" value="PRINT INVOICE" onclick="myFunction()">
 <div id=print>
					
	
							
<table id =space width="760" height="397" border="0" align="center">
  <tr>
    <td width="222" height="198"><img src="logo1.png" width="114" height="115"  alt=""/></td>
    <td width="317"><p><strong>ICYM Karate-Do</strong></p>
      <p>Manager of ICYM Karate-Do,</p>
      <p></p></td>
    <td height="198"><p>Serial No : <?php echo $row['et_id'] ?></p>
      <p>&nbsp;</p>
      <p>Date : <?php echo $row['paid_date']?></p></td>
    </tr>
   
  <tr>
    <td height="118" colspan="3"><p>Received with thanks from : <?php echo $row['username']?></p>
      <p>A sum of RM: <?php echo $row['amount']?></p>
      <p>On account of Membership plan: <?php echo $row['planName']?></p></td>
    </tr>
  
  <tr>
    <td height="73" colspan="2"><p>&nbsp;</p></td>
    <td width="207"><p>&nbsp;</p>
      <p>Signature</p></td>
  </tr>
</table>

</div>
</body>
<a class="btn-sm px-4 py-3 d-flex home-button" style="background-color:#2a2e32" 
   href="<?php echo (isset($_SESSION['is_admin_logged_in']) && $_SESSION['is_admin_logged_in'] ? 'view_mem.php' : '../../dashboard/coach/view_mem.php'); ?>">
    Return Back
</a>

</html>
