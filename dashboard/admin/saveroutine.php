<?php
	require '../../include/db_conn.php';
	page_protect();
	
		
$rname = $_POST["rname"];
$day1 = $_POST["day1"];
$day2 = $_POST["day2"];
$day3 = $_POST["day3"];
$day4 = $_POST["day4"];
$day5 = $_POST["day5"];
$day6 = $_POST["day6"];
$pid = $_POST["pidd"];
$hasApproved = $_POST["hasApproved"];
$staff = $_POST["staff"];

// Prepare the SQL statement
$sql = "INSERT INTO sports_timetable (tid, planid, staffid, tname, day1, day2, day3, day4, day5, day6, hasApproved) 
        VALUES (UUID(), '$pid', '$staff', '$rname', '$day1', '$day2', '$day3', '$day4', '$day5', '$day6', '$hasApproved')";

	
		$result=mysqli_query($con,$sql);
		if($result){	
		
			echo "<head><script>alert('Timetable Added');</script></head></html>";
			echo "<meta http-equiv='refresh' content='0; url=editroutine.php'>";
		}else{
			echo "<head><script>alert('Routine Added Failed');</script></head></html>";
			echo mysqli_error($con);
		}
	
	
?>