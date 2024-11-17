<?php
require '../../include/db_conn.php';
$planid=$_GET['q'];
$query="select * from plan where planid='".$planid."'";
$res=mysqli_query($con,$query);
if($res){
	$row=mysqli_fetch_array($res,MYSQLI_ASSOC);
	// echo "<tr><td>".$row['amount']."</td></tr>";
	echo "<tr>
		<td height='35'>AMOUNT:</td>
		<td height='35'>&nbsp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;<input id='boxx' type='text' value='RM".$row['amount']."' readonly></td></tr>
		</tr>
	";
}

?>
